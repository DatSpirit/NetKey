<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-8 animate-fade-in">
        
        {{-- SUCCESS HEADER CARD --}}
        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl p-10 text-center relative overflow-hidden border border-gray-100 dark:border-gray-750">
            <!-- Background Decoration -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-400 dark:bg-emerald-600 rounded-full blur-3xl opacity-10 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                @if($transaction->status === 'success')
                    <div class="w-24 h-24 mb-8 bg-gradient-to-br from-emerald-400 to-green-600 rounded-full flex items-center justify-center shadow-xl transform hover:scale-105 transition-transform border-4 border-white dark:border-gray-700">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                @elseif($transaction->status === 'pending')
                    <div class="w-24 h-24 mb-8 bg-gradient-to-br from-amber-400 to-orange-600 rounded-full flex items-center justify-center shadow-xl border-4 border-white dark:border-gray-700">
                        <svg class="w-12 h-12 text-white animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                @else
                    <div class="w-24 h-24 mb-8 bg-gradient-to-br from-red-400 to-pink-600 rounded-full flex items-center justify-center shadow-xl border-4 border-white dark:border-gray-700">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                @endif

                <h2 class="text-4xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">
                    @if($transaction->status === 'success')
                        {{ __('Payment Successful!') }}
                    @elseif($transaction->status === 'pending')
                        {{ __('Order Received') }}
                    @else
                        {{ __('Payment Failed') }}
                    @endif
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium max-w-md mx-auto">
                    @if($transaction->status === 'success')
                        {{ __('Your transaction has been completed successfully.') }}
                    @elseif($transaction->status === 'pending')
                        {{ __('We are waiting for bank confirmation.') }}
                    @else
                        {{ __('There was an error processing your payment.') }}
                    @endif
                </p>

                <div class="mt-8 flex items-center gap-3 px-6 py-2 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600 shadow-inner">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Order Code') }}</span>
                    <span class="font-mono font-black text-indigo-600 dark:text-indigo-400 text-lg">{{ $transaction->order_code }}</span>
                    <button onclick="navigator.clipboard.writeText('{{ $transaction->order_code }}')" class="hover:text-indigo-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- TRANSACTION INFO ROW --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-xl flex flex-col items-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Amount Paid') }}</span>
                <p class="text-2xl font-black text-gray-900 dark:text-white">
                    {{ number_format($transaction->amount) }}
                    <span class="text-sm font-bold text-gray-400 ml-1">{{ $transaction->currency === 'COINKEY' ? 'Coin' : 'Đ' }}</span>
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-xl flex flex-col items-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Status') }}</span>
                <div class="flex items-center gap-2 px-4 py-1.5 rounded-full font-black text-sm uppercase tracking-wide {{ $transaction->status === 'success' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30' : 'bg-red-50 text-red-600 dark:bg-red-900/30' }}">
                    <span class="w-2 h-2 rounded-full {{ $transaction->status === 'success' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                    {{ $transaction->status }}
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-xl flex flex-col items-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Time') }}</span>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-black text-gray-800 dark:text-white">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- DETAIL GRADIENT CARD --}}
        @if($transaction->status === 'success')
            <div class="relative overflow-hidden bg-gradient-to-br from-[#6366f1] via-[#a855f7] to-[#ec4899] rounded-[2.5rem] shadow-2xl p-8 sm:p-10 text-white">
                <!-- Background Decoration -->
                <div class="absolute -right-16 -top-16 opacity-20 pointer-events-none transform rotate-12">
                     <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12.65 10C11.83 7.67 9.61 6 7 6c-3.31 0-6 2.69-6 6s2.69 6 6 6c2.61 0 4.83-1.67 5.65-4H17v4h4v-4h2v-4H12.65zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path></svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg border border-white/20">
                             <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </div>
                        <div>
                            @if($is_package_purchase || $is_custom_key_purchase)
                                <h3 class="text-3xl font-black tracking-tight leading-none">{{ __('New Key Created!') }}</h3>
                                <p class="text-white/70 font-bold uppercase text-[0.65rem] tracking-[0.3em] mt-2">{{ $product?->name ?? 'Package' }}</p>
                            @elseif($is_custom_extension || $is_key_extension)
                                <h3 class="text-3xl font-black tracking-tight leading-none">{{ __('Key Extended!') }}</h3>
                                <p class="text-white/70 font-bold uppercase text-[0.65rem] tracking-[0.3em] mt-2">{{ __('Success') }}</p>
                            @elseif($is_coinkey_deposit)
                                <h3 class="text-3xl font-black tracking-tight leading-none">{{ __('Coins Added!') }}</h3>
                                <p class="text-white/70 font-bold uppercase text-[0.65rem] tracking-[0.3em] mt-2">{{ __('Balance Updated') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Data Content based on type --}}
                    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/15 shadow-inner">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            
                            {{-- Specific info for Keys --}}
                            @if($key_code || ($key && $key->key_code))
                                <div class="col-span-1 sm:col-span-2 lg:col-span-1 flex flex-col justify-center">
                                    <span class="text-[0.65rem] font-bold text-white/60 uppercase tracking-widest mb-1">{{ __('Key Code') }}</span>
                                    <div class="flex items-center gap-3">
                                        <code class="text-xl sm:text-2xl font-black font-mono tracking-wider text-white bg-white/10 px-3 py-1.5 rounded-xl border border-white/20">
                                            {{ $key_code ?? $key->key_code }}
                                        </code>
                                        <button onclick="navigator.clipboard.writeText('{{ $key_code ?? $key->key_code }}')" class="p-2 hover:bg-white/20 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if($duration_minutes || $days_added)
                                <div class="flex flex-col justify-center border-l border-white/10 sm:pl-8">
                                    <span class="text-[0.65rem] font-bold text-white/60 uppercase tracking-widest mb-1">{{ __('Duration') }}</span>
                                    <p class="text-2xl font-black">
                                        {{ number_format($duration_minutes ?? ($days_added * 24 * 60)) }}
                                        <span class="text-sm text-white/60 lowercase ml-1">{{ __('minutes') }}</span>
                                    </p>
                                </div>
                            @endif

                            @if($key && $key->expires_at)
                                <div class="flex flex-col justify-center border-l border-white/10 lg:pl-8">
                                    <span class="text-[0.65rem] font-bold text-white/60 uppercase tracking-widest mb-1">{{ __('Expiration') }}</span>
                                    <p class="text-xl font-black text-white px-3 py-1 bg-white/20 rounded-xl inline-block">
                                        {{ $key->expires_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            @endif

                            {{-- Specific info for Coins --}}
                            @if($is_coinkey_deposit)
                                <div class="col-span-3 flex flex-col items-center py-4">
                                    <span class="text-[0.65rem] font-bold text-white/60 uppercase tracking-widest mb-2">{{ __('Coins Added') }}</span>
                                    <p class="text-5xl font-black">+{{ number_format($product?->coinkey_amount ?? 0) }} coin</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Dynamic Action Link --}}
                    <div class="mt-10 flex justify-center">
                        @if($key)
                            <a href="{{ route('keys.keydetails', $key->id) }}"
                                class="w-full sm:w-auto px-10 py-5 bg-white text-indigo-700 rounded-2xl font-black text-xl hover:bg-opacity-90 shadow-2xl transition-all active:scale-95 flex items-center justify-center gap-3">
                                <span>{{ __('View Key Details') }}</span>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @elseif($is_coinkey_deposit)
                            <a href="{{ route('wallet.index') }}"
                                class="w-full sm:w-auto px-10 py-5 bg-white text-emerald-700 rounded-2xl font-black text-xl hover:bg-opacity-90 shadow-2xl transition-all active:scale-95 flex items-center justify-center gap-3">
                                <span>{{ __('View My Wallet') }}</span>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- MASTER ACTIONS --}}
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('dashboard') }}"
                class="flex-1 px-8 py-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 rounded-2xl font-black text-xl transition-all hover:bg-gray-50 dark:hover:bg-gray-750 shadow-xl flex items-center justify-center gap-3 group">
                <svg class="w-6 h-6 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ __('Go to Dashboard') }}
            </a>
            <a href="{{ route('keys.index') }}"
                class="flex-1 px-8 py-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 rounded-2xl font-black text-xl transition-all hover:bg-gray-50 dark:hover:bg-gray-750 shadow-xl flex items-center justify-center gap-3 group">
                <svg class="w-6 h-6 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                {{ __('View My Keys') }}
            </a>
        </div>
        
        <p class="text-center text-xs font-bold text-gray-400 uppercase tracking-[0.3em] py-8">
            {{ __('Need help?') }} <a href="{{ route('support.contact') }}" class="text-indigo-600 hover:underline">{{ __('Contact Support') }}</a>
        </p>

    </div>
</x-app-layout>