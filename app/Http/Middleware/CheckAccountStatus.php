<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Admin luôn được phép truy cập
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Kiểm tra tài khoản bị suspended
        if ($user->account_status === 'suspended') {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been suspended. Please contact support.');
        }

        // Kiểm tra tài khoản hết hạn
        if ($user->expires_at && $user->expires_at->isPast()) {
            // Cập nhật status nếu chưa được cập nhật
            if ($user->account_status !== 'expired') {
                $user->update(['account_status' => 'expired']);
            }

            // Danh sách các route cho phép khi hết hạn
            $allowedRoutes = [
                'wallet.index',
                'wallet.buy-package',
                'wallet.purchase-package',
                'wallet.check-balance',
                'wallet.calculate-price',
                'logout',
                'profile.edit', // Cho phép xem profile để biết tình trạng
                'profile.update',
                'password.confirm',
                'password.confirm.custom',
            ];

            // Nếu route hiện tại không nằm trong danh sách cho phép -> Redirect
            if (!$request->routeIs($allowedRoutes)) {
                return redirect()->route('wallet.buy-package')
                    ->with('error', 'Your account has expired. Please renew your subscription to access this feature.');
            }
        }

        return $next($request);
    }
}