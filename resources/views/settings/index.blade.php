<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ __('System Settings') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Quản lý cài đặt tài khoản và hệ thống</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6" x-data="{ activeTab: 'account' }">

        {{-- Settings Navigation Tabs --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-2">
            <div class="flex flex-wrap gap-2">
                <button @click="activeTab = 'account'"
                    :class="activeTab === 'account' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                    class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-semibold transition-all">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Account') }}
                </button>
                <button @click="activeTab = 'security'"
                    :class="activeTab === 'security' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                    class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-semibold transition-all">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    {{ __('Security') }}
                </button>
                <button @click="activeTab = 'notifications'"
                    :class="activeTab === 'notifications' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                    class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-semibold transition-all">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    {{ __('Notifications') }}
                </button>
                <button @click="activeTab = 'preferences'"
                    :class="activeTab === 'preferences' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                    class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-semibold transition-all">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    {{ __('Preferences') }}
                </button>
            </div>
        </div>

        {{-- Account Settings --}}
        <div x-show="activeTab === 'account'" class="space-y-6">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    {{ __('Profile Information') }}
                </h3>

                <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full
                                Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email
                                Address</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone
                                Number</label>
                            <input type="tel" name="phone_number" value="{{ Auth::user()->phone_number }}"
                                placeholder="+84 xxx xxx xxx"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Join
                                Date</label>
                            <input type="text" value="{{ Auth::user()->created_at->format('d/m/Y') }}" disabled
                                class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-xl cursor-not-allowed opacity-75">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address</label>
                        <textarea name="address" rows="3" placeholder="Enter your address..."
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">{{ Auth::user()->address }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg shadow-indigo-500/50">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            {{-- Account Status --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Account Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Email Verified</span>
                            @if(Auth::user()->email_verified_at)
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            {{ Auth::user()->email_verified_at ? 'Your email is verified' : 'Email not verified' }}
                        </p>
                    </div>

                    <div
                        class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Account Active</span>
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Since
                            {{ Auth::user()->created_at->format('M Y') }}
                        </p>
                    </div>

                    <div
                        class="p-4 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Member Level</span>
                            <span class="text-purple-600 dark:text-purple-400 font-bold">
                                {{ Auth::user()->is_admin ? 'Admin' : 'Regular' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ Auth::user()->login_count ?? 0 }} logins
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Security Settings --}}
        <div x-show="activeTab === 'security'" class="space-y-6" style="display: none;">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    Change Password
                </h3>

                <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Current
                            Password</label>
                        <input type="password" name="current_password"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">New
                            Password</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm New
                            Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-xl font-semibold hover:from-red-700 hover:to-pink-700 transition-all shadow-lg shadow-red-500/50">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- Two-Factor Authentication --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    Two-Factor Authentication
                </h3>

                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="security_settings" value="1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">Enable 2FA</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Secure your account with 2FA.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="2fa_enabled" class="sr-only peer" {{ (Auth::user()->preferences['security']['2fa_enabled'] ?? false) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save
                            Security Settings</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Notification Settings --}}
        <div x-show="activeTab === 'notifications'" class="space-y-6" style="display: none;">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Email Notifications</h3>
                <form action="{{ route('settings.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="notification_settings" value="1">
                    @php
                        $prefs = Auth::user()->preferences['notifications'] ?? [];
                        $notifSettings = [
                            ['key' => 'order_updates', 'title' => 'Order Updates', 'desc' => 'Get notified when your order status changes'],
                            ['key' => 'new_products', 'title' => 'New Products', 'desc' => 'Receive alerts about new products'],
                            ['key' => 'promotions', 'title' => 'Promotions', 'desc' => 'Special offers and discounts'],
                            ['key' => 'newsletter', 'title' => 'Newsletter', 'desc' => 'Weekly newsletter with updates'],
                        ];
                    @endphp
                    @foreach($notifSettings as $setting)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $setting['title'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $setting['desc'] }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="{{ $setting['key'] }}" class="sr-only peer" {{ ($prefs[$setting['key']] ?? false) ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                    @endforeach
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700">Save
                            Notifications</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Preferences --}}
        <div x-show="activeTab === 'preferences'" class="space-y-6" style="display: none;">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Display Preferences</h3>
                <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="preference_settings" value="1">
                    @php
                        $disp = Auth::user()->preferences['display'] ?? [];
                    @endphp
                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Language</label>
                        <select name="language"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="en" {{ ($disp['language'] ?? '') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="vi" {{ ($disp['language'] ?? '') == 'vi' ? 'selected' : '' }}>Tiếng Việt
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                        <select name="currency"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="VND" {{ ($disp['currency'] ?? '') == 'VND' ? 'selected' : '' }}>VND -
                                Vietnamese Dong</option>
                            <option value="USD" {{ ($disp['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD - US Dollar
                            </option>
                            <option value="EUR" {{ ($disp['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR - Euro
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Timezone</label>
                        <select name="timezone"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="Asia/Ho_Chi_Minh" {{ ($disp['timezone'] ?? '') == 'Asia/Ho_Chi_Minh' ? 'selected' : '' }}>
                                (UTC+07:00) Bangkok, Hanoi, Jakarta</option>
                            <option value="Asia/Singapore" {{ ($disp['timezone'] ?? '') == 'Asia/Singapore' ? 'selected' : '' }}>
                                (UTC+08:00) Beijing, Singapore</option>
                            <option value="Asia/Tokyo" {{ ($disp['timezone'] ?? '') == 'Asia/Tokyo' ? 'selected' : '' }}>
                                (UTC+09:00) Tokyo, Seoul</option>
                            <option value="America/New_York" {{ ($disp['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>
                                (UTC-05:00) Eastern Time (US)</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg shadow-indigo-500/50">
                            {{ __('Save Preferences') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>