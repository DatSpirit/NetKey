<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\Models\User;
use App\Services\KeyManagementService;
use App\Models\KeyHistory;
use Exception;

use App\Events\TransactionStatusUpdated;

class WebhookController extends Controller
{
    /**
     * Xử lý webhook từ PayOS.
     * Áp dụng Cache Lock (Rate Limiting) ngay sau khi trích xuất OrderCode.
     */
    public function handleWebhook(Request $request)
    {
        $startTime = microtime(true);
        $requestId = uniqid('webhook_', true);
        $orderCode = null; // Khởi tạo biến orderCode

        // Log request info đầu tiên
        Log::info("1. [{$requestId}] Webhook received", [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            // Lấy toàn bộ payload ngay lập tức
            $payload = $request->all();

            // Lấy Raw Content (để lưu log thô)
            $rawPayload = $request->getContent();

            // Nếu rawPayload rỗng encode lại từ payload
            if (empty($rawPayload)) {
                $rawPayload = json_encode($payload);
            }


            // Log dữ liệu để debug
            // Log::info("Webhook RAW:", ['raw' => $rawPayload]);
            // Log::info("Webhook DATA:", $payload);

            // cách xem dữ liệu: notepad storage/logs/laravel.log


            // ===================================
            // 1️⃣ VALIDATE PAYLOAD STRUCTURE & EXTRACT ORDER CODE
            // ===================================
            if (!isset($payload['data'], $payload['signature'])) {
                Log::warning("ERROR 1[{$requestId}] Invalid payload structure");
                return response()->json(['error' => 0, 'message' => 'ok'], 200);
            }

            // Lấy orderCode ngay sau khi xác thực
            $orderCode = $payload['data']['orderCode'] ?? null;

            if (!$orderCode) {
                Log::warning("ERROR 2[{$requestId}] Missing orderCode");
                return response()->json(['error' => 0, 'message' => 'ok'], 200);
            }

            // ===================================
            // 2️⃣ CACHE-BASED IMMEDIATE RATE LIMITING
            // Chặn ngay lập tức TẤT CẢ các webhook có cùng orderCode trong X giây.
            // ===================================
            $cacheKey = "webhook_processing:{$orderCode}";
            $lockDurationSeconds = 300; // Khóa trong 300 giây, 1 tuần = 604800 giây

            // Sử dụng Cache::add() để tạo lock ngăn chặn.
            if (!Cache::add($cacheKey, $requestId, $lockDurationSeconds)) {
                Log::warning("ERROR 3[{$requestId}] Duplicate webhook blocked (Early)", [
                    'orderCode' => $orderCode,
                    'current_lock_holder' => Cache::get($cacheKey)
                ]);


                return response()->json([
                    'error' => 0,
                    'message' => 'cache_lock_blocked_early',
                    'data' => ['orderCode' => $orderCode]
                ], 200);
            }
            Log::info("2. [{$requestId}] Acquired cache lock for processing");

            // ===================================
            // 3️⃣ VERIFY SIGNATURE 
            // ===================================
            $data = $payload['data'];
            $signature = $payload['signature'];
            $code = $payload['code'] ?? null;
            $desc = $payload['desc'] ?? null;

            if (!$this->verifySignature($data, $signature)) {
                Log::error("❌ [{$requestId}] INVALID SIGNATURE - Possible attack!", [
                    'ip' => $request->ip(),
                    'signature' => substr($signature, 0, 20) . '...'
                ]);

                // Giải phóng lock Cache trước khi trả về lỗi.
                Cache::forget($cacheKey);
                return response()->json(['error' => 1, 'message' => 'Invalid signature'], 401);
            }

            Log::info("3. [{$requestId}] Signature verified");

            // ===================================
            // 4️⃣ EXTRACT PAYMENT DATA
            // ===================================
            $amount = $data['amount'] ?? 0;
            $paymentCode = $data['code'] ?? $code;
            $description = $data['description'] ?? '';
            $status = $data['status'] ?? null;

            // Payment details
            $paymentReference = $data['reference'] ?? null;
            $accountNumber = $data['accountNumber'] ?? null;
            $counterAccountName = $data['counterAccountName'] ?? null;
            $counterAccountNumber = $data['counterAccountNumber'] ?? null;
            $counterAccountBankId = $data['counterAccountBankId'] ?? null;
            $counterAccountBankName = $data['counterAccountBankName'] ?? null;
            $paymentLinkId = $data['paymentLinkId'] ?? null;
            $transactionDateTime = $data['transactionDateTime'] ?? null;

            Log::info("4. [{$requestId}] Payment details", [
                'orderCode' => $orderCode,
                'amount' => $amount,
                'reference' => $paymentReference,
                'status' => $status,
            ]);

            // ===================================
            // 5️⃣ DATABASE TRANSACTION WITH LOCKING
            // ===================================
            DB::beginTransaction();

            try {
                // Tìm transaction với row lock
                $transaction = Transaction::where('order_code', $orderCode)
                    ->lockForUpdate()
                    ->first();

                // ===================================
                // 6️⃣ CREATE NEW TRANSACTION IF NOT EXISTS
                // ===================================
                if (!$transaction) {
                    Log::info("5. [{$requestId}] Creating new transaction", [
                        'orderCode' => $orderCode
                    ]);

                    $transaction = Transaction::create([
                        'user_id' => null,
                        'product_id' => null,
                        'order_code' => $orderCode,
                        'amount' => $amount,
                        'status' => 'pending',
                        'description' => $description,
                        'is_processed' => false,
                        'payment_reference' => $paymentReference,
                        'account_number' => $accountNumber,
                        'counter_account_name' => $counterAccountName,
                        'counter_account_number' => $counterAccountNumber,
                        'counter_account_bank_id' => $counterAccountBankId,
                        'counter_account_bank_name' => $counterAccountBankName,
                        'payment_link_id' => $paymentLinkId,
                        'transaction_datetime' => $transactionDateTime ? date('Y-m-d H:i:s', strtotime($transactionDateTime)) : null,
                        'currency' => $data['currency'] ?? 'VND',
                        'raw_payload' => $rawPayload,
                        'response_data' => $data,
                    ]);
                }

                // ===================================
                // 7️⃣ CHECK DUPLICATE BY SIGNATURE (Lớp bảo vệ vĩnh viễn trong DB)
                // ===================================
                if ($transaction->isDuplicateWebhook($signature)) {
                    Log::warning("ERROR 4: [{$requestId}] Duplicate webhook ignored by signature (DB check)", [
                        'orderCode' => $orderCode,
                        'current_status' => $transaction->status,
                        'is_processed' => $transaction->is_processed,
                        'processed_at' => $transaction->processed_at,
                        'signature_match' => true
                    ]);

                    DB::commit();

                    return response()->json([
                        'error' => 0,
                        'message' => 'duplicate_ignored',
                        'data' => [
                            'orderCode' => $orderCode,
                            'status' => $transaction->status,
                            'processed_at' => $transaction->processed_at
                        ]
                    ], 200);
                }

                // ===================================
                // 8️⃣ DETERMINE NEW STATUS
                // ===================================
                $newStatus = $this->determineStatus($status, $paymentCode);
                $oldStatus = $transaction->status;

                Log::info("6. [{$requestId}] Status mapping", [
                    'orderCode' => $orderCode,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'was_processed' => $transaction->is_processed
                ]);

                // ===================================
                // 9️⃣ UPDATE TRANSACTION
                // ===================================
                $transaction->update([
                    'status' => $newStatus,
                    'amount' => $amount,
                    'description' => $this->sanitizeDescription("{$desc} - {$description}"),
                    'payment_reference' => $paymentReference,
                    'account_number' => $accountNumber,
                    'counter_account_name' => $counterAccountName,
                    'counter_account_number' => $counterAccountNumber,
                    'counter_account_bank_id' => $counterAccountBankId,
                    'counter_account_bank_name' => $counterAccountBankName,
                    'payment_link_id' => $paymentLinkId,
                    'transaction_datetime' => $transactionDateTime ? date('Y-m-d H:i:s', strtotime($transactionDateTime)) : null,
                    'currency' => $data['currency'] ?? 'VND',
                    'raw_payload' => $rawPayload,
                ]);
                // Nếu transaction mới tạo (không có response_data), mới set
                if (empty($transaction->response_data)) {
                    $transaction->update([
                        'response_data' => $data,
                    ]);
                }

                if ($newStatus === 'success' && $oldStatus !== 'success') {
                    $this->fulfillOrder($transaction);
                }

                // ===================================
                // 🔟 MARK AS PROCESSED
                // ===================================
                $transaction->markAsProcessed($signature, $payload, $rawPayload);

                // 🔥 PHÁT TÍN HIỆU REAL-TIME (Broadcasting)
                broadcast(new TransactionStatusUpdated($transaction))->toOthers();

                $processingTime = round((microtime(true) - $startTime) * 1000, 2);

                Log::info("7. [{$requestId}] Transaction processed successfully", [
                    'id' => $transaction->id,
                    'orderCode' => $orderCode,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'amount' => $amount,
                    'reference' => $paymentReference,
                    'processed_at' => $transaction->processed_at,
                    'processing_time_ms' => $processingTime
                ]);

                DB::commit();
                Cache::forget($cacheKey); // Giải phóng lock Cache

                return response()->json([
                    'error' => 0,
                    'message' => 'ok',
                    'data' => [
                        'orderCode' => $orderCode,
                        'status' => $newStatus,
                        'processed_at' => $transaction->processed_at->toIso8601String(),
                        'processing_time_ms' => $processingTime
                    ]
                ], 200);
            } catch (Exception $e) {
                DB::rollBack();
                Cache::forget($cacheKey); // Giải phóng lock Cache
                throw $e;
            }
        } catch (Exception $e) {
            $processingTime = round((microtime(true) - $startTime) * 1000, 2);

            Log::error("ERROR 5: [{$requestId}] Webhook processing error", [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'orderCode' => $orderCode ?? 'unknown',
                'processing_time_ms' => $processingTime
            ]);

            // Nếu orderCode đã được trích xuất và có thể đã thiết lập lock, đảm bảo lock được giải phóng.
            if ($orderCode) {
                Cache::forget("webhook_processing:{$orderCode}");
            }

            // Luôn trả về 200 OK theo yêu cầu của cổng thanh toán.
            return response()->json(['error' => 0, 'message' => 'ok'], 200);
        }
    }

    /**
     * Xác định trạng thái từ status hoặc code
     */
    private function determineStatus(?string $status, ?string $code): string
    {
        // Ưu tiên status text
        if ($status) {
            return match (strtoupper($status)) {
                'PAID' => 'success',
                'CANCELLED' => 'cancelled',
                'PENDING' => 'pending',
                default => 'failed'
            };
        }

        // Fallback sang code
        return match ($code) {
            '00' => 'success',
            '01' => 'failed',
            '02' => 'pending',
            default => 'cancelled'
        };
    }

    /**
     * Xác thực chữ ký webhook
     */
    private function verifySignature(array $data, string $receivedSignature): bool
    {
        try {
            $checksumKey = env('PAYOS_CHECKSUM_KEY');

            if (!$checksumKey) {
                Log::critical('❌ PAYOS_CHECKSUM_KEY not configured!');
                return false;
            }

            // Sắp xếp keys theo alphabet
            ksort($data);

            // Tạo chuỗi data
            $dataStr = '';
            foreach ($data as $key => $value) {
                $dataStr .= $key . '=' . $value . '&';
            }
            $dataStr = rtrim($dataStr, '&');

            // Tính HMAC-SHA256
            $computedSignature = hash_hmac('sha256', $dataStr, $checksumKey);

            // So sánh an toàn
            return hash_equals($computedSignature, $receivedSignature);
        } catch (Exception $e) {
            Log::error('ERROR 6: Signature verification exception', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Sanitize description
     */
    private function sanitizeDescription(string $description): string
    {
        $description = strip_tags($description);
        // Loại bỏ ký tự không phải chữ, số, khoảng trắng, hoặc ký tự cơ bản (-,_,.,!,?)
        $description = preg_replace('/[^\p{L}\p{N}\s\-_.,!?]/u', '', $description);
        return substr($description, 0, 500);
    }

    /**
     *  Hàm thực hiện giao hàng 
     */
    private function fulfillOrder(Transaction $transaction)
    {
        try {
            $user = $transaction->user;
            $product = $transaction->product;
            $meta = $transaction->response_data ?? [];

            //  0. KIỂM TRA GIA HẠN TÙY CHỈNH (Custom Extension)
            if (isset($meta['type']) && $meta['type'] === 'custom_key_extension') {
                $keyId = $meta['key_id'] ?? null;
                $duration = $meta['duration_minutes'] ?? 0;

                if (!$keyId || !$duration) {
                    Log::error("⌚ Webhook: Missing key_id or duration for custom extension", [
                        'transaction_id' => $transaction->id,
                        'meta' => $meta
                    ]);
                    return;
                }

                // LOAD KEY với RELATIONS
                $key = \App\Models\ProductKey::with(['product', 'user'])->find($keyId);
                if (!$key) {
                    Log::error("⌚ Webhook: Key not found for custom extension", [
                        'transaction_id' => $transaction->id,
                        'key_id' => $keyId
                    ]);
                    return;
                }

                // Thực hiện gia hạn
                $oldExpiry = $key->expires_at ? $key->expires_at->toDateTimeString() : 'N/A';
                $key->extend($duration);
                $key->status = 'active';

                if ($transaction->currency === 'VND') {
                    $key->key_cost += ($transaction->amount / 1000);
                }
                $key->save();

                // CẬP NHẬT METADATA với actual_new_expiry
                $transaction->update([
                    'response_data' => array_merge($meta, [
                        'actual_new_expiry' => $key->expires_at->toIso8601String(),
                        'webhook_processed_at' => now()->toIso8601String(),
                    ])
                ]);

                // Ghi lịch sử
                \App\Models\KeyHistory::log($key->id, 'custom_extend', "Gia hạn tùy chỉnh qua PayOS - Đơn #{$transaction->order_code}", [
                    'package_name' => $meta['package_name'] ?? 'N/A',
                    'days_added' => $meta['days_added'] ?? 0,
                    'minutes_added' => $duration,
                    'cost_vnd' => $transaction->amount,
                    'old_expiry' => $oldExpiry,
                    'new_expiry' => $key->expires_at->toDateTimeString()
                ]);

                Log::info("✅ Custom Extended Key {$key->key_code} via Webhook", [
                    'key_id' => $key->id,
                    'days_added' => $meta['days_added'] ?? 0,
                    'new_expiry' => $key->expires_at
                ]);

                return; // DỪNG LẠI
            }


            // 1.  KIỂM TRA GIA HẠN KEY TRƯỚC
            if (isset($meta['type']) && $meta['type'] === 'key_extension') {
                $keyId = $meta['key_id'] ?? null;
                $duration = $meta['duration_minutes'] ?? 0;

                if (!$keyId || !$duration) {
                    Log::error("⌚  Webhook: Missing key_id or duration for extension", [
                        'transaction_id' => $transaction->id,
                        'meta' => $meta
                    ]);
                    return;
                }

                //  TÌM KEY VÀ GIA HẠN
                $key = \App\Models\ProductKey::find($keyId);

                if (!$key) {
                    Log::error("⌚ Webhook: Key not found for extension", [
                        'transaction_id' => $transaction->id,
                        'key_id' => $keyId
                    ]);
                    return;
                }

                //  THỰC HIỆN GIA HẠN
                $oldExpiry = $key->expires_at ? $key->expires_at->toDateTimeString() : 'N/A'; // LƯU TRỮ NGÀY HẾT HẠN CŨ
                $key->extend($duration);
                $key->status = 'active';

                //  CỘNG CHI PHÍ VÀO KEY (nếu dùng PayOS)
                if ($transaction->currency === 'VND') {
                    $key->key_cost += ($transaction->amount / 1000); // Convert VND sang Coin
                }

                $key->save();

                //  GHI LỊCH SỬ
                \App\Models\KeyHistory::log($key->id, 'extend', "Gia hạn qua PayOS - Đơn #{$transaction->order_code}", [
                    'added_minutes' => $duration,
                    'cost_vnd' => $transaction->amount,
                    'old_expiry' => $oldExpiry, // NGÀY HẾT HẠN CŨ
                    'new_expiry' => $key->expires_at->toDateTimeString()
                ]);

                Log::info("✅ Extended Key {$key->key_code} via Webhook", [
                    'key_id' => $key->id,
                    'duration' => $duration,
                    'new_expiry' => $key->expires_at
                ]);

                return; // DỪNG LẠI, KHÔNG TẠO KEY MỚI
            }

            // 2. KIỂM TRA MUA CUSTOM KEY (PayOS)
            if (isset($meta['type']) && $meta['type'] === 'custom_key_purchase') {
                $keyService = app(\App\Services\KeyManagementService::class);

                $newKey = $keyService->createCustomKey(
                    user: $user,
                    customKeyCode: $meta['key_code'],
                    durationMinutes: $meta['duration_minutes'],
                    baseProduct: $product,
                    assignedToEmail: $meta['assigned_email'] ?? null
                );
                // CẬP NHẬT key_id vào transaction
                $transaction->update([
                    'response_data' => array_merge($meta, [
                        'key_id' => $newKey->id,
                    ])
                ]);

                // Cập nhật transaction_id cho ProductKey
                $newKey->update(['transaction_id' => $transaction->id]);


                // GHI LỊCH TẠO KEY
                \App\Models\KeyHistory::log($newKey->id, 'create', "Tạo Custom Key qua PayOS - Order code:{$transaction->order_code}", [
                    'Key_code' => $newKey->key_code,
                    'cost_vnd' => $transaction->amount,
                    'duration_minutes' => $meta['duration_minutes'],
                    'product_name' => $product->name ?? 'N/A',
                ]);

                Log::info("✅ Created Custom Key {$meta['key_code']} via Webhook");
                return;
            }

            //  3. XỬ LÝ NẠP COINKEY
            if ($product->isCoinkeyPack()) {
                $wallet = $user->getOrCreateWallet();

                $wallet->deposit(
                    amount: $product->coinkey_amount,
                    type: 'deposit',
                    description: "Nạp {$product->coinkey_amount} Coinkey qua PayOS - Order #{$transaction->order_code}",
                    referenceType: 'Transaction',
                    referenceId: $transaction->id
                );

                Log::info("💰 Deposited {$product->coinkey_amount} Coinkey to user {$user->id}");
                return;
            }

            // 4. TẠO KEY MỚI CHO GÓI SERVICE (mua key thường qua PayOS)
            if ($product->isServicePackage()) {
                $keyService = app(\App\Services\KeyManagementService::class);
                $key = $keyService->createKeyFromPackage($user, $product, $transaction);

                if ($key) {


                    // CẬP NHẬT metadata với key_id và key_code
                    $transaction->update([
                        'response_data' => array_merge($meta, [
                            'type' => 'package_purchase', // Đánh dấu mua gói key
                            'key_id' => $key->id,
                            'key_code' => $key->key_code,
                            'duration_minutes' => $product->duration_minutes,
                        ])
                    ]);

                    // GHI LỊCH SỬ
                    \App\Models\KeyHistory::log($key->id, 'create', "Mua gói {$product->name} qua PayOS", [
                        'order_code' => $transaction->order_code,
                        'cost_vnd' => $transaction->amount,
                        'key_code' => $key->key_code,
                    ]);

                    Log::info("🔑 Created new key for user {$user->id}", [
                        'key_code' => $key->key_code,
                        'key_id' => $key->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("❌ Fulfillment Error for Order {$transaction->order_code}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'transaction_id' => $transaction->id,
            ]);

            $transaction->update([
                'notes' => 'Fulfillment failed - requires manual processing: ' . $e->getMessage()
            ]);
        }
    }
}
