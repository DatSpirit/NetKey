<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    // ============================================================
    // SETUP (bật 2FA)
    // ============================================================

    /**
     * Hiển thị trang Setup 2FA với QR Code
     */
    public function setup()
    {
        $user = Auth::user();

        if ($user->two_factor_enabled) {
            return redirect()->route('profile.edit')->with('info', 'Bạn đã bật 2FA rồi.');
        }

        // Tạo secret mới (chưa lưu vào DB, chờ confirm)
        $secret = $this->google2fa->generateSecretKey();
        session(['2fa_temp_secret' => $secret]);

        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        // Generate QR SVG bằng BaconQrCode (không cần internet)
        $renderer = new ImageRenderer(
            new RendererStyle(192),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($qrCodeUrl);

        return view('auth.two-factor.setup', compact('secret', 'qrCodeSvg'));
    }

    /**
     * Xác nhận mã OTP lần đầu để kích hoạt 2FA
     */
    public function confirm(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $user = Auth::user();
        $secret = session('2fa_temp_secret');

        if (!$secret) {
            return back()->with('error', 'Phiên đã hết hạn. Vui lòng bắt đầu lại.');
        }

        $valid = $this->google2fa->verifyKeyNewer($secret, $request->otp, null, 1);

        if (!$valid) {
            return back()->withErrors(['otp' => 'Mã OTP không đúng. Vui lòng thử lại.']);
        }

        // Lưu secret + bật 2FA
        $user->update([
            'two_factor_secret'       => encrypt($secret),
            'two_factor_enabled'      => true,
            'two_factor_confirmed_at' => now(),
        ]);

        session()->forget('2fa_temp_secret');

        return redirect()->route('profile.edit')
            ->with('success', '✅ 2FA đã được kích hoạt thành công!');
    }

    /**
     * Tắt 2FA
     */
    public function disable(Request $request)
    {
        $request->validate(['current_password' => 'required|current_password']);

        Auth::user()->update([
            'two_factor_secret'       => null,
            'two_factor_enabled'      => false,
            'two_factor_confirmed_at' => null,
        ]);

        session()->forget('two_factor_verified');

        return back()->with('success', '2FA đã được tắt.');
    }

    // ============================================================
    // VERIFY (nhập OTP mỗi lần đăng nhập)
    // ============================================================

    /**
     * Hiển thị trang nhập OTP
     */
    public function showVerify()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->two_factor_enabled) {
            return redirect()->intended(route('dashboard'));
        }

        return view('auth.two-factor.verify');
    }

    /**
     * Xác minh OTP khi đăng nhập
     */
    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $user = Auth::user();
        $secret = decrypt($user->two_factor_secret);

        $valid = $this->google2fa->verifyKeyNewer($secret, $request->otp, null, 1);

        if (!$valid) {
            return back()->withErrors(['otp' => 'Mã OTP không đúng. Vui lòng thử lại.']);
        }

        // Đánh dấu đã xác minh trong session (24 giờ)
        $request->session()->put('two_factor_verified', true);

        $intended = session()->pull('2fa_intended', route('admin.dashboard'));
        return redirect($intended);
    }
}
