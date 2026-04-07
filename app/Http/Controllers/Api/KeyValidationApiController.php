<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\KeyValidationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * KeyValidationApiController
 *
 * Public JSON endpoint allowing external/third-party applications to verify
 * the validity of any licence key via a simple GET request.
 *
 * Endpoint: GET /api/validate/{key}
 *
 * For every validation request the system logs:
 *   - Caller's IP address
 *   - User-Agent
 *   - Device identifier (optional query param ?device_id=)
 *
 * Returns the key's status and remaining validity time.
 * This turns NetKey into an infrastructure service that can be integrated
 * with any third-party software.
 */
class KeyValidationApiController extends Controller
{
    protected KeyValidationService $validationService;

    public function __construct(KeyValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * Validate a licence key.
     *
     * GET /api/validate/{key}
     *
     * Query params (optional):
     *   ?device_id=<string>   — Unique identifier of the calling device/machine
     *
     * Response (200 – valid key):
     * {
     *   "valid": true,
     *   "status": "active",
     *   "message": "Key is valid",
     *   "expires_at": "2026-12-31T23:59:59+00:00",
     *   "remaining_days": 268,
     *   "remaining_minutes": 386123,
     *   "request_id": "uuid-..."
     * }
     *
     * Response (403 – invalid / expired / suspended):
     * {
     *   "valid": false,
     *   "status": "expired",
     *   "message": "Key has expired",
     *   "expires_at": "2026-01-01T00:00:00+00:00",
     *   "remaining_days": 0,
     *   "remaining_minutes": 0,
     *   "request_id": "uuid-..."
     * }
     */
    public function validate(Request $request, string $key): JsonResponse
    {
        // Collect caller context for logging
        $ip        = $request->ip();
        $userAgent = $request->userAgent() ?? 'Unknown';
        $deviceId  = $request->query('device_id');   // optional

        Log::info('[KeyValidationApi] Incoming validation request', [
            'key'        => substr($key, 0, 8) . '***',
            'ip'         => $ip,
            'user_agent' => $userAgent,
            'device_id'  => $deviceId,
        ]);

        try {
            // Delegate to the shared validation service (handles locking, rate-limit,
            // idempotency, DB pessimistic lock, and logging automatically)
            $result = $this->validationService->validateKey(
                keyCode:   $key,
                ipAddress: $ip,
                userAgent: $userAgent,
                deviceId:  $deviceId
            );

            // Build a clean, third-party-friendly response
            $valid         = $result['valid'] ?? false;
            $serviceStatus = $result['status'] ?? 'error';
            $data          = $result['data'] ?? [];

            $response = [
                'valid'             => $valid,
                'status'            => $valid ? 'active' : $serviceStatus,
                'message'           => $result['message'] ?? ($valid ? 'Key is valid' : 'Key is not valid'),
                'expires_at'        => $data['expires_at'] ?? ($result['expired_at'] ?? null),
                'remaining_days'    => $data['remaining_days'] ?? 0,
                'remaining_minutes' => $data['remaining_minutes'] ?? 0,
                'request_id'        => $result['request_id'] ?? null,
            ];

            // HTTP status code mapping
            $httpStatus = match ($serviceStatus) {
                'success'                   => 200,
                'rate_limited', 'suspicious' => 429,
                'invalid', 'expired',
                'suspended'                  => 403,
                default                      => 500,
            };

            if ($valid) {
                $httpStatus = 200;
            }

            return response()->json($response, $httpStatus);

        } catch (\Throwable $e) {
            Log::error('[KeyValidationApi] Unexpected error', [
                'key'   => substr($key, 0, 8) . '***',
                'ip'    => $ip,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'valid'   => false,
                'status'  => 'error',
                'message' => 'Internal server error. Please try again later.',
            ], 500);
        }
    }
}
