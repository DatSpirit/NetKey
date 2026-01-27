<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Handle different settings updates
        if ($request->has('current_password')) {
            return $this->updatePassword($request);
        }

        if ($request->has('name')) {
            return $this->updateProfile($request);
        }

        if ($request->has('notification_settings')) {
            return $this->updateNotifications($request);
        }

        if ($request->has('preference_settings')) {
            return $this->updatePreferences($request);
        }

        if ($request->has('security_settings')) {
            return $this->updateSecurity($request);
        }

        return redirect()->back()->with('error', 'Invalid request');
    }

    private function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully');
    }

    private function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'phone_number', 'address']));

        return back()->with('success', 'Profile updated successfully');
    }

    private function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $preferences = $user->preferences ?? [];

        $preferences['notifications'] = [
            'order_updates' => $request->has('order_updates'),
            'new_products' => $request->has('new_products'),
            'promotions' => $request->has('promotions'),
            'newsletter' => $request->has('newsletter'),
        ];

        $user->preferences = $preferences;
        $user->save();

        return back()->with('success', 'Notification settings updated');
    }

    private function updatePreferences(Request $request)
    {
        $user = Auth::user();
        $preferences = $user->preferences ?? [];

        $preferences['display'] = [
            'language' => $request->input('language', 'vi'),
            'currency' => $request->input('currency', 'VND'),
            'timezone' => $request->input('timezone', 'UTC+07:00'),
        ];

        $user->preferences = $preferences;
        $user->save();

        return back()->with('success', 'Display preferences updated');
    }

    private function updateSecurity(Request $request)
    {
        $user = Auth::user();
        $preferences = $user->preferences ?? [];

        // Handle 2FA Toggle
        // Checkbox logic: strictly set true or false based on presence
        $isEnabled = $request->has('2fa_enabled');

        $preferences['security'] = [
            '2fa_enabled' => $isEnabled,
        ];

        $msg = $isEnabled ? 'Two-Factor Authentication Enabled' : 'Two-Factor Authentication Disabled';

        $user->preferences = $preferences;
        $user->save();

        return back()->with('success', $msg);
    }
}