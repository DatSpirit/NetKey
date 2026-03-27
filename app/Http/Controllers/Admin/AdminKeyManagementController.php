<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductKey;
use App\Models\User;
use App\Models\AdminAuditLog;
use App\Services\KeyManagementService;
use Illuminate\Http\Request;

class AdminKeyManagementController extends Controller
{
    protected KeyManagementService $keyService;

    public static $middleware = [
        'auth',
        'admin',
    ];

    public function __construct(KeyManagementService $keyService)
    {
        $this->keyService = $keyService;
    }

    /**
     * Danh sách tất cả key (Admin) - Bao gồm cả key đã xóa
     */
    public function index(Request $request)
    {
        // Sử dụng withTrashed() để lấy cả key đã xóa
        $query = ProductKey::withTrashed()->with(['user', 'product']);

        // Filters
        if ($request->filled('status')) {
            $status = $request->status;

            if ($status === 'expired') {
                // Lọc Hết hạn: Bao gồm trạng thái 'expired' or ('active' nhưng đã quá ngày)
                $query->where(function ($q) {
                    $q->where('status', 'expired')
                        ->orWhere(function ($sub) {
                            $sub->where('status', 'active')
                                ->whereNotNull('expires_at')
                                ->where('expires_at', '<=', now());
                        });
                });
            } elseif ($status === 'active') {
                // Lọc Hoạt động: Phải là 'active' VÀ (chưa hết hạn hoặc vĩnh viễn)
                $query->where('status', 'active')
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                    });
            } else {
                // Các trạng thái khác (suspended, revoked) lọc bình thường
                $query->where('status', $status);
            }
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter xem key đã xóa
        if ($request->filled('show_deleted') && $request->show_deleted === 'only') {
            $query->onlyTrashed();
        } elseif ($request->filled('show_deleted') && $request->show_deleted === 'with') {
            // withTrashed() đã được gọi ở trên
        } else {
            // Mặc định chỉ hiện key chưa xóa
            $query->whereNull('deleted_at');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $search = $request->search;

                if (is_numeric($search)) {
                    $q->where('id', $search);
                }

                $q->orWhere('key_code', 'like', '%' . $search . '%')
                    ->orWhere('assigned_to_email', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', '%' . $search . '%')
                            ->orWhere('name', 'like', '%' . $search . '%')
                            ->orWhere('id', $search);
                    });
            });
        }

        $keys = $query->orderBy('created_at', 'desc')->paginate(50);

        // Stats
        $stats = [
            'total' => ProductKey::count(),
            'active' => ProductKey::active()->count(),
            'expired' => ProductKey::expired()->count(),
            'suspended' => ProductKey::where('status', 'suspended')->count(),
            'deleted' => ProductKey::onlyTrashed()->count(),
            'expiring_soon' => ProductKey::expiringSoon(7)->count(),
            'total_validations' => ProductKey::sum('validation_count'),
            'total_spent' => ProductKey::sum('key_cost'),
        ];

        return view('admin.keys.index', compact('keys', 'stats'));
    }

    /**
     * Chi tiết key (Admin view) - Read Only
     */
    public function show($id)
    {
        // Lấy cả key đã xóa
        $key = ProductKey::withTrashed()->with(['user', 'product'])->findOrFail($id);

        $recentValidations = $key->validationLogs()
            ->orderBy('validated_at', 'desc')
            ->limit(10)
            ->get();

        $validationStats = [
            'total_validations' => $key->validation_count,
            'success_count' => $key->validationLogs()->success()->count(),
            'failed_count' => $key->validationLogs()->failed()->count(),
            'unique_ips' => $key->validationLogs()->distinct('ip_address')->count('ip_address'),
        ];

        return view('admin.keys.show', compact(
            'key',
            'recentValidations',
            'validationStats'
        ));
    }

    /**
     * Trang chỉnh sửa key (Admin) - Full Features
     */
    public function edit($id)
    {
        // Lấy cả key đã xóa
        $key = ProductKey::withTrashed()->with(['user', 'product'])->findOrFail($id);

        return view('admin.keys.edit', compact('key'));
    }

    /**
     * Cập nhật key (Admin) - Chỉnh sửa toàn diện
     */
    public function update(Request $request, $id)
    {
        $key = ProductKey::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'key_code' => 'required|string|max:255|unique:product_keys,key_code,' . $key->id,
            'status' => 'required|in:active,expired,suspended,revoked',
            'expires_at' => 'nullable|date',
            'duration_minutes' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        // Lưu thông tin cũ để ghi log
        $oldKeyCode = $key->key_code;
        $oldStatus = $key->status;
        $oldExpiresAt = $key->expires_at;

        // Cập nhật
        $key->update([
            'key_code' => $validated['key_code'],
            'status' => $validated['status'],
            'expires_at' => $validated['expires_at'],
            'duration_minutes' => $validated['duration_minutes'],
            'notes' => $validated['notes'] ?? $key->notes,
        ]);

        // Ghi log thay đổi
        $changes = [];
        if ($oldKeyCode !== $key->key_code) {
            $changes[] = "Key code: {$oldKeyCode} → {$key->key_code}";
        }
        if ($oldStatus !== $key->status) {
            $changes[] = "Status: {$oldStatus} → {$key->status}";
        }
        if ($oldExpiresAt != $key->expires_at) {
            $changes[] = "Expires: " . ($oldExpiresAt ? $oldExpiresAt->format('Y-m-d H:i') : 'N/A') .
                " → " . ($key->expires_at ? $key->expires_at->format('Y-m-d H:i') : 'N/A');
        }

        if (!empty($changes)) {
            \App\Models\KeyHistory::log(
                $key->id,
                'admin_update',
                "Admin cập nhật: " . implode(', ', $changes),
                ['admin_id' => auth()->id()]
            );
        }

        return back()->with('success', '✅ Cập nhật key thành công!');
    }

    /**
     * Suspend key (Admin)
     */
    public function suspend(Request $request, $id)
    {
        $key = ProductKey::withTrashed()->findOrFail($id);
        $reason = $request->input('reason', 'Admin suspended');

        $key->suspend($reason);
        \App\Models\KeyHistory::log($key->id, 'suspend', "Admin suspend: {$reason}");

        AdminAuditLog::log('suspend_key', 'ProductKey', $key->id,
            "Suspend key {$key->key_code}: {$reason}");

        return back()->with('success', 'Key suspended successfully');
    }

    /**
     * Activate key (Admin)
     */
    public function activate($id)
    {
        $key = ProductKey::withTrashed()->findOrFail($id);

        if ($key->isExpired()) {
            return back()->with('error', 'Cannot activate expired key. Please extend it first.');
        }

        $key->update(['status' => 'active']);

        \App\Models\KeyHistory::log($key->id, 'activate', 'Admin activated key');

        return back()->with('success', 'Key activated successfully');
    }

    /**
     * Revoke key (Admin)
     */
    public function revoke(Request $request, $id)
    {
        $key = ProductKey::withTrashed()->findOrFail($id);
        $reason = $request->input('reason', 'Admin revoked');

        $key->revoke($reason);
        \App\Models\KeyHistory::log($key->id, 'revoke', "Admin revoke: {$reason}");

        AdminAuditLog::log('revoke_key', 'ProductKey', $key->id,
            "Thu hồi key {$key->key_code}: {$reason}");

        return back()->with('success', 'Key revoked successfully');
    }

    /**
     * Extend key (Admin - free of charge)
     */
    public function extendAdmin(Request $request, $id)
    {
        $request->validate([
            'additional_minutes' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
        ]);

        $key = ProductKey::withTrashed()->findOrFail($id);
        $key->extend($request->additional_minutes);

        $reason = $request->reason ?? 'Admin extension';
        $key->notes = ($key->notes ?? '') . "\nAdmin extended: {$reason}";
        $key->save();

        \App\Models\KeyHistory::log(
            $key->id,
            'extend',
            "Admin gia hạn +{$request->additional_minutes} phút: {$reason}",
            ['admin_id' => auth()->id()]
        );

        return back()->with('success', 'Key extended successfully');
    }

    /**
     * Xóa mềm key (Admin) - User không thấy, Admin vẫn thấy
     */
    public function destroy($id)
    {
        $key = ProductKey::findOrFail($id); // Chỉ lấy key chưa xóa

        // Soft delete
        $key->delete();

        // Ghi log
        \App\Models\KeyHistory::log(
            $key->id,
            'delete',
            'Admin đã xóa key (soft delete)',
            ['admin_id' => auth()->id()]
        );

        return redirect()
            ->route('admin.keys.index')
            ->with('success', '🗑️ Key đã được xóa (soft delete). User không còn thấy key này.');
    }

    /**
     * Khôi phục key đã xóa
     */
    public function restore($id)
    {
        $key = ProductKey::onlyTrashed()->findOrFail($id);
        $key->restore();

        \App\Models\KeyHistory::log(
            $key->id,
            'restore',
            'Admin khôi phục key',
            ['admin_id' => auth()->id()]
        );

        return back()->with('success', '♻️ Key đã được khôi phục!');
    }

    /**
     * Xóa vĩnh viễn key
     */
    public function forceDelete($id)
    {
        $key = ProductKey::onlyTrashed()->findOrFail($id);

        // Lưu info trước khi xóa
        $keyCode = $key->key_code;
        $keyId = $key->id;
        $key->forceDelete();

        AdminAuditLog::log('force_delete_key', 'ProductKey', $keyId,
            "Xóa vĩnh viễn key {$keyCode} khỏi database");

        return redirect()
            ->route('admin.keys.index')
            ->with('success', "⚠️ Key {$keyCode} đã bị xóa vĩnh viễn khỏi database!");
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:suspend,activate,revoke,delete',
            'key_ids' => 'required|array',
            'key_ids.*' => 'exists:product_keys,id',
            'reason' => 'nullable|string|max:500',
        ]);

        $keys = ProductKey::withTrashed()->whereIn('id', $request->key_ids)->get();

        foreach ($keys as $key) {
            switch ($request->action) {
                case 'suspend':
                    $key->suspend($request->reason);
                    break;
                case 'activate':
                    if (!$key->isExpired()) {
                        $key->update(['status' => 'active']);
                    }
                    break;
                case 'revoke':
                    $key->revoke($request->reason);
                    break;
                case 'delete':
                    $key->delete();
                    break;
            }
        }

        return back()->with('success', "Bulk action completed for " . count($keys) . " keys");
    }

    /**
     * Export keys to CSV
     */
    public function export(Request $request)
    {
        $query = ProductKey::withTrashed()->with(['user', 'product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $keys = $query->orderBy('created_at', 'desc')->get();

        $filename = 'product_keys_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($keys) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Headers
            fputcsv($file, [
                'ID',
                'Key Code',
                'Type',
                'User Email',
                'Product',
                'Status',
                'Duration (Minutes)',
                'Key Cost',
                'Activated At',
                'Expires At',
                'Validation Count',
                'Created At',
                'Deleted At',
            ]);

            foreach ($keys as $key) {
                fputcsv($file, [
                    $key->id,
                    $key->key_code,
                    ucfirst($key->key_type),
                    $key->user->email ?? 'N/A',
                    $key->product->name ?? 'N/A',
                    ucfirst($key->status),
                    $key->duration_minutes,
                    number_format($key->key_cost, 2),
                    $key->activated_at?->format('Y-m-d H:i:s') ?? 'Not activated',
                    $key->expires_at?->format('Y-m-d H:i:s') ?? 'Never',
                    $key->validation_count,
                    $key->created_at->format('Y-m-d H:i:s'),
                    $key->deleted_at?->format('Y-m-d H:i:s') ?? 'Not deleted',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Validation statistics
     */
    public function validationStats()
    {
        $stats = [
            'total_validations' => \App\Models\KeyValidationLog::count(),
            'success_validations' => \App\Models\KeyValidationLog::success()->count(),
            'failed_validations' => \App\Models\KeyValidationLog::failed()->count(),
            'unique_ips' => \App\Models\KeyValidationLog::distinct('ip_address')->count('ip_address'),
            'validations_today' => \App\Models\KeyValidationLog::whereDate('validated_at', today())->count(),
        ];

        // Top validated keys
        $topKeys = ProductKey::withCount('validationLogs')
            ->orderBy('validation_logs_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.keys.validation-stats', compact('stats', 'topKeys'));
    }
}
