@push('styles')
<style>
/* ── PROFILE PAGE — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Interior elements */
.bg-gray-50.dark\:bg-gray-700\/50,
.bg-gray-50.dark\:bg-gray-700 {
    background: var(--bg-elevated) !important;
    border-color: var(--border) !important;
}

/* Sub-navigation buttons */
.bg-indigo-50.dark\:bg-indigo-900 {
    background: rgba(37, 99, 235, 0.1) !important;
    border-color: rgba(37, 99, 235, 0.2) !important;
}
.text-indigo-600.dark\:text-indigo-200,
.text-indigo-600.dark\:text-indigo-400 { color: #2563eb !important; }

/* Action Buttons */
.bg-indigo-600 { background-color: #2563eb !important; }
.hover\:bg-indigo-700:hover { background-color: #1d4ed8 !important; }

/* Status Colors */
.text-green-600.dark\:text-green-400 { color: #10b981 !important; }
.bg-green-100.dark\:bg-green-900 { background: rgba(16, 185, 129, 0.15) !important; color: #10b981 !important; }
.border-green-500 { border-color: #10b981 !important; }

.text-red-600 { color: #ef4444 !important; }
.bg-red-100.dark\:bg-red-900 { background: rgba(239, 68, 68, 0.15) !important; color: #ef4444 !important;}
.border-red-500 { border-color: #ef4444 !important; }

</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 dark:text-white flex items-center">
            <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <!-- Thanh điều hướng phụ giữa các trang hồ sơ -->
    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="flex flex-wrap gap-3 p-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <!-- Nút chuyển sang Profile Settings -->
                <a href="{{ route('profile.edit') }}"
                    class="px-5 py-2.5 text-sm font-bold rounded-xl text-indigo-600 bg-indigo-50 border border-indigo-200 shadow-sm hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-800/50 dark:hover:bg-indigo-800/50 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ __('Profile Settings') }}
                </a>

                <!-- Nút chuyển sang User Profile -->
                <a href="{{ route('user.profile') }}"
                    class="px-5 py-2.5 text-sm font-medium rounded-xl text-gray-700 bg-gray-50 border border-gray-200 shadow-sm hover:bg-gray-100 dark:bg-gray-700/50 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ __('User Profile') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Nội dung chỉnh sửa thông tin -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/50 rounded-2xl text-green-700 dark:text-green-300 shadow-sm"
                 x-data="{ show: true }" x-show="show" x-transition
                 x-init="setTimeout(() => show = false, 5000)">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 rounded-2xl text-red-700 dark:text-red-300 shadow-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Account Status & Expiration Info -->

            <div
                class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl border-l-[6px] {{ $user->account_status === 'active' ? 'border-green-500' : 'border-red-500' }}">
                <section>
                    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                <span class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </span>
                                {{ __('Account Status') }}
                            </h2>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 ml-[2.75rem]">
                                {{ __('Check your account expiration details and status.') }}
                            </p>
                        </div>
                        <div
                            class="inline-flex px-5 py-2 rounded-full text-sm font-black uppercase tracking-wider shadow-sm {{ $user->account_status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 border border-green-200 dark:border-green-800/50' : 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border border-red-200 dark:border-red-800/50' }}">
                            {{ ucfirst($user->account_status) }}
                        </div>
                    </header>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Expiration Date -->
                        <div class="p-5 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Expiration Date') }}</div>
                            <div class="text-2xl font-black text-gray-900 dark:text-white">
                                @if($user->expires_at)
                                    {{ $user->expires_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-green-600 dark:text-green-400 flex items-center">
                                        <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Lifetime Access
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Days Remaining -->
                        <div class="p-5 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Time Remaining') }}</div>
                            <div
                                class="text-2xl font-black {{ ($user->expires_at && $user->expires_at->isPast()) ? 'text-red-600 dark:text-red-400' : 'text-indigo-600 dark:text-indigo-400' }}">
                                @if(!$user->expires_at)
                                    ∞
                                @elseif($user->expires_at->isPast())
                                    Expired
                                @else
                                    {{ ceil(now()->diffInDays($user->expires_at, false)) }} days
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-start md:justify-end">
                            @if($user->account_status !== 'active' || ($user->expires_at && $user->expires_at->diffInDays(now()) < 7))
                                <a href="{{ route('wallet.buy-package') }}"
                                    class="inline-flex items-center justify-center w-full md:w-auto px-6 py-4 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-indigo-700 shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    {{ __('Extend Now') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            <!-- Cập nhật thông tin cá nhân -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Cập nhật mật khẩu -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Xóa tài khoản -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>