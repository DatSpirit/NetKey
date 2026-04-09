<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-8">
        <!-- Header with Back Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-3xl text-gray-900 dark:text-white">{{ __('Key Details') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-tight font-mono">{{ $key->key_code }}</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-750 transition-all shadow-sm font-semibold group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Dashboard') }}
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border-l-4 border-emerald-500 p-4 rounded-r-2xl shadow-sm animate-fade-in-down">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-emerald-800 dark:text-emerald-200 font-bold uppercase text-sm tracking-wide">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Premium Key Status Card -->
        <div class="relative overflow-hidden bg-gradient-to-br from-[#4158D0] via-[#C850C0] to-[#FFCC70] rounded-[2.5rem] shadow-2xl p-8 sm:p-12 text-white">
            <!-- Decorative Background Patterns -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl opacity-50 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-900/20 rounded-full -ml-32 -mb-32 blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10">
                <!-- Status & Auto-Renew -->
                <div class="flex items-center justify-between mb-10">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-white/25 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg border border-white/30 transform hover:rotate-3 transition-transform">
                            @if ($key->isActive())
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif($key->isExpired())
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-white/70 uppercase font-bold tracking-[0.2em] mb-1">{{ __('Status') }}</p>
                            <h3 class="text-3xl sm:text-4xl font-black tracking-tight">
                                @if ($key->isActive())
                                    {{ __('Active') }}
                                @elseif($key->isExpired())
                                    {{ __('Expired') }}
                                @else
                                    {{ ucfirst($key->status) }}
                                @endif
                            </h3>
                        </div>
                    </div>
                    
                    <button class="hidden sm:flex items-center gap-2 px-6 py-2.5 bg-white/15 hover:bg-white/25 backdrop-blur-md rounded-xl font-bold border border-white/20 transition-all text-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('Auto-Renew') }}
                    </button>
                </div>

                <!-- Key Code Display -->
                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/15 shadow-inner mb-8">
                    <p class="text-xs sm:text-sm text-white/60 uppercase font-bold tracking-widest mb-3">{{ __('Key Code') }}</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                        <p class="text-2xl sm:text-[2.75rem] font-mono font-black tracking-[0.1em] break-all leading-none text-white drop-shadow-md">
                            {{ $key->key_code }}
                        </p>
                        <button onclick="copyToClipboard('{{ $key->key_code }}')"
                            class="w-full sm:w-auto px-8 py-4 bg-white text-indigo-700 rounded-2xl font-black text-lg hover:bg-gray-100 transition-all active:scale-95 shadow-xl flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                            {{ __('Copy Key') }}
                        </button>
                    </div>
                </div>

                <!-- Time & Expiration Sub-cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @if ($key->expires_at)
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 flex items-center gap-5 shadow-sm">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[0.65rem] sm:text-xs text-white/60 uppercase font-bold tracking-widest mb-0.5">{{ __('Time Remaining') }}</p>
                                <p class="text-xl sm:text-2xl font-black">
                                    @if ($key->isExpired())
                                        0 {{ __('days') }}
                                    @elseif ($key->getRemainingSeconds() > 86400)
                                        {{ $key->getRemainingDays() ?? '∞' }} {{ __('days') }}
                                    @elseif ($key->getRemainingSeconds() > 3600)
                                        {{ $key->getRemainingMinutes() }} {{ __('min') }}
                                    @else
                                        {{ $key->getRemainingSeconds() }} {{ __('sec') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 flex items-center gap-5 shadow-sm">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[0.65rem] sm:text-xs text-white/60 uppercase font-bold tracking-widest mb-0.5">{{ __('Expires on') }}</p>
                                <p class="text-xl sm:text-2xl font-black">{{ $key->expires_at->format('d/m/Y - H:i:s') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="col-span-2 bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center shadow-sm">
                            <p class="text-2xl sm:text-3xl font-black">♾️ {{ __('Lifetime Access') }}</p>
                            <p class="text-sm text-white/60 mt-1 uppercase tracking-widest">{{ __('No expiration date') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- General Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-700 p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/40 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-black text-2xl text-gray-900 dark:text-white tracking-tight">{{ __('General Info') }}</h3>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Key Type') }}</span>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-xs font-black uppercase tracking-widest">
                            {{ $key->key_type === 'custom' ? __('Custom') : __('Auto') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pb-4 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Total Time') }}</span>
                        <span class="font-black text-gray-900 dark:text-white text-lg">
                            {{ number_format($key->duration_minutes) }} <span class="text-xs text-gray-500 font-bold ml-1 uppercase">{{ __('minutes') }}</span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between pb-4 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Cost') }}</span>
                        <span class="font-black text-emerald-600 dark:text-emerald-400 text-lg flex items-center gap-1">
                            {{ number_format($key->key_cost) }} coin
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Activated At') }}</span>
                        <span class="font-black text-gray-900 dark:text-white">
                            {{ $key->activated_at?->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') ?? __('Not Activated') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Usage Stats Card -->
            <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-700 p-8 flex flex-col">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-black text-2xl text-gray-900 dark:text-white tracking-tight">{{ __('Usage Stats') }}</h3>
                </div>
                
                <div class="space-y-8 flex-1">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                            <p class="text-[0.65rem] font-bold text-gray-500 uppercase tracking-widest mb-1">{{ __('Validation Count') }}</p>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($key->validation_count) }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                            <p class="text-[0.65rem] font-bold text-gray-500 uppercase tracking-widest mb-1">{{ __('Last Validated') }}</p>
                            <p class="text-sm font-black text-gray-900 dark:text-white mt-2">{{ $key->last_validated_at?->diffForHumans() ?? __('Never') }}</p>
                        </div>
                    </div>
                    
                    <!-- Analytics Placeholder (Match Reference 1) -->
                    <div class="mt-4 flex flex-col items-center justify-center py-6">
                        <svg class="w-16 h-16 text-gray-200 dark:text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        <p class="text-xs font-black text-gray-300 dark:text-gray-600 uppercase tracking-[0.3em]">{{ __('Realtime Metrics') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Master Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if ($key->isActive())
                <a href="{{ route('keys.extend-confirm', $key->id) }}"
                    class="flex items-center justify-center gap-3 px-8 py-5 bg-[#00D1A0] hover:bg-[#00B88C] text-white rounded-2xl font-black text-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95 group">
                    <svg class="w-7 h-7 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Extend Duration') }}
                </a>
            @endif
            <a href="{{ route('keys.history', $key->id) }}"
                class="flex items-center justify-center gap-3 px-8 py-5 bg-[#F3F4F6] dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-2xl font-black text-xl border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95 group">
                <svg class="w-7 h-7 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ __('View Detailed History') }}
            </a>
        </div>
    </div>

    <!-- Notification Toast logic can be added here -->

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show a modern toast or just alert
                alert('✅ ' + '{{ __('Copied') }}' + ': ' + text);
            });
        }
    </script>
</x-app-layout>