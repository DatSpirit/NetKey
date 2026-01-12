<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <!-- Thanh điều hướng phụ giữa các trang hồ sơ -->
    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="flex flex-wrap gap-3 p-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <!-- Nút chuyển sang Profile Settings -->
                <a href="{{ route('profile.edit') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-lg text-indigo-600 bg-indigo-50 border border-indigo-200 shadow-sm hover:bg-indigo-100 dark:bg-indigo-900 dark:text-indigo-200 dark:hover:bg-indigo-800 transition">
                    {{ __('Profile Settings') }}
                </a>

                <!-- Nút chuyển sang User Profile -->
                <a href="{{ route('user.profile') }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg text-gray-700 bg-gray-50 border border-gray-200 shadow-sm hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
                    {{ __('User Profile') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Nội dung chỉnh sửa thông tin -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Account Status & Expiration Info -->
            <div
                class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border-l-4 {{ $user->account_status === 'active' ? 'border-green-500' : 'border-red-500' }}">
                <section>
                    <header class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Account Status') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Check your account expiration details and status.') }}
                            </p>
                        </div>
                        <div
                            class="px-4 py-2 rounded-full text-sm font-bold {{ $user->account_status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                            {{ ucfirst($user->account_status) }}
                        </div>
                    </header>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Expiration Date -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Expiration Date</div>
                            <div class="text-xl font-bold text-gray-900 dark:text-white">
                                @if($user->expires_at)
                                    {{ $user->expires_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-green-600 dark:text-green-400">Lifetime Access</span>
                                @endif
                            </div>
                        </div>

                        <!-- Days Remaining -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Time Remaining</div>
                            <div
                                class="text-xl font-bold {{ ($user->expires_at && $user->expires_at->isPast()) ? 'text-red-600' : 'text-indigo-600 dark:text-indigo-400' }}">
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
                        <div class="flex items-center justify-end">
                            @if($user->account_status !== 'active' || ($user->expires_at && $user->expires_at->diffInDays(now()) < 7))
                                <a href="{{ route('wallet.buy-package') }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Extend Now') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            <!-- Cập nhật thông tin cá nhân -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Cập nhật mật khẩu -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Xóa tài khoản -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>