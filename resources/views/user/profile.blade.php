@push('styles')
<style>
/* ── USER PROFILE — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Interior elements */
.bg-gray-50.dark\:bg-gray-700,
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-layer) !important;
    border-color: var(--border) !important;
}

/* Navigation Tabs */
.bg-indigo-50.dark\:bg-indigo-900 {
    background: rgba(37, 99, 235, 0.1) !important;
    border-color: rgba(37, 99, 235, 0.2) !important;
}

/* Highlights */
.text-indigo-600.dark\:text-indigo-200 { color: #2563eb !important; }
.text-indigo-500 { color: #2563eb !important; }
.bg-indigo-50.dark\:bg-indigo-700 { background-color: rgba(37, 99, 235, 0.1) !important; }
.text-indigo-600.dark\:text-indigo-100 { color: #2563eb !important; }
.ring-indigo-200.dark\:ring-indigo-600 { --tw-ring-color: rgba(37, 99, 235, 0.2) !important; }
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 dark:text-white flex items-center">
            <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            {{ __('User Personal') }}
        </h2>
    </x-slot>

    <!-- THANH ĐIỀU HƯỚNG  -->
    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="flex flex-wrap gap-3 p-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-200 dark:border-gray-700">

                <!-- Nút Thụ động (Profile Settings) -->
                <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 text-sm font-medium rounded-xl 
                          text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 
                          border border-gray-200 dark:border-gray-600
                          hover:bg-gray-100 dark:hover:bg-gray-600 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ __('Profile Settings') }}
                </a>

                <!-- Nút Active (User Profile) -->
                <!-- Thể hiện người dùng đang ở đây -->
                <a href="{{ route('user.profile') }}" class="px-5 py-2.5 text-sm font-bold rounded-xl 
                          text-indigo-600 dark:text-indigo-300 
                          bg-indigo-50 dark:bg-indigo-900/30 
                          border border-indigo-200 dark:border-indigo-800/50 
                          shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ __('User Profile') }}
                </a>
            </div>
        </div>
    </div>


    <!-- NỘI DUNG TRANG -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Box trình bày-->
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl p-8 lg:p-10 border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 dark:bg-indigo-900/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none z-0"></div>

                <div class="relative z-10">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 border-b dark:border-gray-700 pb-4 flex items-center">
                        <span class="p-1.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </span>
                        {{ __('Personal Information') }}
                    </h3>

                    <!-- Hiển thị Avatar Placeholder -->
                    <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-8 mb-10">
                        <div class="
                            w-24 h-24 
                            bg-indigo-50 dark:bg-indigo-900/40 
                            rounded-2xl flex items-center justify-center 
                            text-indigo-600 dark:text-indigo-400 
                            text-5xl font-black 
                            border-4 border-indigo-100 dark:border-indigo-800
                            shadow-md transition-all duration-300 transform hover:scale-105 shrink-0
                        ">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <!-- $user được truyền từ UserController sang -->
                        <div class="text-center sm:text-left mt-2 content-center">
                            <p class="text-3xl sm:text-4xl font-black text-gray-900 dark:text-white tracking-tight leading-none mb-2">{{ $user->name }}</p>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700/50 inline-block px-3 py-1 rounded-full uppercase tracking-wider">
                                Member since {{ $user->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Danh sách thông tin chi tiết -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/30 p-8 rounded-2xl border border-gray-100 dark:border-gray-600">

                        <div class="flex items-start">
                            <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mr-4 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 dark:text-indigo-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Email Address') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white break-all">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mr-4 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 dark:text-indigo-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 9h2l-2 5h-2l2-5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7l-2 5h4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('User ID') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white font-mono">{{ $user->id }}</p>
                            </div>
                        </div>

                        @if($user->phone_number)
                            <div class="flex items-start">
                                <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mr-4 shrink-0">
                                    <svg class="h-6 w-6 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Phone Number') }}</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $user->phone_number }}</p>
                                </div>
                            </div>
                        @endif

                        @if($user->address)
                            <div class="flex items-start">
                                <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mr-4 shrink-0">
                                    <svg class="h-6 w-6 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Address') }}</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $user->address }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-start">
                            <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mr-4 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 dark:text-indigo-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Join Date') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 p-4 rounded-xl border border-orange-100 dark:border-orange-800/50">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            {{ __('This information is protected. Only logged-in users can access it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>