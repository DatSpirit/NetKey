@push('styles')
<style>
/* ── SETTINGS INDEX — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Interior elements */
.bg-gray-50.dark\:bg-gray-700,
.bg-gray-100.dark\:bg-gray-700 {
    background: var(--bg-layer) !important;
    border-color: var(--border) !important;
}

/* Inputs */
input.bg-gray-50.dark\:bg-gray-700,
textarea.bg-gray-50.dark\:bg-gray-700,
select.bg-gray-50.dark\:bg-gray-700 {
    background: var(--bg-inner) !important;
    color: var(--text-color) !important;
    border: 1px solid var(--border) !important;
}
input:focus, textarea:focus, select:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 1px #2563eb !important;
}

/* Tab Active State */
.bg-indigo-600 { background-color: #2563eb !important; }

/* Gradients for buttons */
.from-indigo-600.to-purple-600 { background: #2563eb !important; }
.hover\:from-indigo-700.hover\:to-purple-700:hover { background: #1d4ed8 !important; }

/* Status Cards overrides */
.bg-green-50.dark\:bg-green-900\/20 { background: rgba(16, 185, 129, 0.1) !important; border-color: rgba(16, 185, 129, 0.2) !important; }
.bg-blue-50.dark\:bg-blue-900\/20 { background: rgba(37, 99, 235, 0.1) !important; border-color: rgba(37, 99, 235, 0.2) !important; }
.bg-purple-50.dark\:bg-purple-900\/20 { background: rgba(168, 85, 247, 0.1) !important; border-color: rgba(168, 85, 247, 0.2) !important; }

.text-indigo-600.dark\:text-indigo-400,
.text-indigo-600 { color: #2563eb !important; }
.text-blue-600.dark\:text-blue-400 { color: #3b82f6 !important; }
.text-green-600 { color: #10b981 !important; }
.text-purple-600 { color: #a855f7 !important; }
.text-red-600.dark\:text-red-400 { color: #ef4444 !important; }

/* Toggle Checkbox styling adjusted for darkmode */
input[type="checkbox"]:checked + div { background-color: #2563eb !important; }
</style>
@endpush

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
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium uppercase tracking-wider">{{ __('Manage your account and system settings') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 py-8" x-data="{ activeTab: 'notifications' }">

        {{-- Settings Navigation Tabs --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-2 overflow-x-auto">
            <div class="flex flex-nowrap md:flex-wrap gap-2 min-w-max md:min-w-0">
                <button @click="activeTab = 'notifications'"
                    :class="activeTab === 'notifications' ? 'bg-indigo-600 text-white shadow-md' : 'bg-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white'"
                    class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    {{ __('Notifications') }}
                </button>
                <button @click="activeTab = 'preferences'"
                    :class="activeTab === 'preferences' ? 'bg-indigo-600 text-white shadow-md' : 'bg-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white'"
                    class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    {{ __('Preferences') }}
                </button>
            </div>
        </div>

        {{-- Notification Settings --}}
        <div x-show="activeTab === 'notifications'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 border-b border-gray-100 dark:border-gray-700 pb-4">
                    {{ __('Email Notifications') }}
                </h3>
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
                        <div class="flex items-center justify-between p-6 bg-gray-50 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700 rounded-2xl hover:border-indigo-200 dark:hover:border-indigo-800 transition-colors">
                            <div>
                                <p class="text-base font-bold text-gray-900 dark:text-white">{{ $setting['title'] }}</p>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">{{ $setting['desc'] }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer ml-4">
                                <input type="checkbox" name="{{ $setting['key'] }}" class="sr-only peer" {{ ($prefs[$setting['key']] ?? false) ? 'checked' : '' }}>
                                <div
                                    class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-500 peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                    @endforeach
                    <div class="flex justify-end pt-6 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{ __('Save Notifications') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Preferences --}}
        <div x-show="activeTab === 'preferences'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 border-b border-gray-100 dark:border-gray-700 pb-4">
                    {{ __('Display Preferences') }}
                </h3>
                <form action="{{ route('settings.update') }}" method="POST" class="space-y-6 max-w-2xl">
                    @csrf
                    <input type="hidden" name="preference_settings" value="1">
                    @php
                        $disp = Auth::user()->preferences['display'] ?? [];
                    @endphp
                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Language') }}</label>
                        <select name="language"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium">
                            <option value="en" {{ ($disp['language'] ?? '') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="vi" {{ ($disp['language'] ?? '') == 'vi' ? 'selected' : '' }}>Tiếng Việt
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Currency') }}</label>
                        <select name="currency"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium">
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
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Timezone') }}</label>
                        <select name="timezone"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium">
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

                    <div class="flex justify-start pt-6">
                        <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{ __('Save Preferences') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>