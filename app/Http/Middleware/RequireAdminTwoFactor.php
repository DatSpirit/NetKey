<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Yêu cầu Admin đã xác minh 2FA trong session.
 * Nếu chưa → redirect đến trang nhập OTP.
 * Nếu Admin chưa bật 2FA → cho qua (chỉ yêu cầu nếu đã bật).
 */
class RequireAdminTwoFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Chỉ áp dụng với Admin đã bật 2FA
        if ($user && $user->isAdmin() && $user->two_factor_enabled) {

            // Kiểm tra session 2FA
            if (!$request->session()->has('two_factor_verified')) {

                // Lưu intended URL để redirect sau khi xác minh
                $request->session()->put('2fa_intended', $request->url());

                return redirect()->route('two-factor.verify');
            }
        }

        return $next($request);
    }
}
