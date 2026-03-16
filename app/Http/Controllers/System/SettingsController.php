<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($request->has('notification_settings')) {
            return $this->updateNotifications($request);
        }

        if ($request->has('preference_settings')) {
            return $this->updatePreferences($request);
        }

        return redirect()->back()->with('error', 'Invalid request');
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
}