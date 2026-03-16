<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                {{-- Nút Quay lại --}}
                <a href="{{ route('admin.transactions.all-transactions') }}"
                    class="group p-3 rounded-2xl bg-white dark:bg-gray-800 text-gray-500 hover:text-blue-600 shadow-sm border border-gray-100 dark:border-gray-700 transition-all duration-200">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight leading-none">
                        {{ __('Transaction Details') }}
                    </h2>
                    <p class="text-[10px] text-gray-400 font-mono mt-2 uppercase tracking-widest">{{ __('ORDER ID') }}: #{{ $transaction->order_code }}</p>
                </div>
            </div>

            {{-- Badge Trạng thái --}}
            @php
                $statusConfig = [
                    'success' => [
                        'bg' => 'bg-emerald-50 dark:bg-emerald-900/20',
                        'text' => 'text-emerald-700 dark:text-emerald-400',
                        'border' => 'border-emerald-100 dark:border-emerald-800/30',
                        'icon' => '✔',
                    ],
                    'pending' => [
                        'bg' => 'bg-amber-50 dark:bg-amber-900/20',
                        'text' => 'text-amber-700 dark:text-amber-400',
                        'border' => 'border-amber-100 dark:border-amber-800/30',
                        'icon' => '⏳',
                    ],
                    'failed' => [
                        'bg' => 'bg-red-50 dark:bg-red-900/20',
                        'text' => 'text-red-700 dark:text-red-400',
                        'border' => 'border-red-100 dark:border-red-800/30',
                        'icon' => '✖',
                    ],
                    'cancelled' => [
                        'bg' => 'bg-gray-50 dark:bg-gray-800',
                        'text' => 'text-gray-600 dark:text-gray-400',
                        'border' => 'border-gray-200 dark:border-gray-700',
                        'icon' => '🚫',
                    ],
                ];
                $conf = $statusConfig[$transaction->status] ?? $statusConfig['cancelled'];
            @endphp
            <div
                class="flex items-center gap-3 px-5 py-2.5 rounded-2xl border {{ $conf['bg'] }} {{ $conf['border'] }} {{ $conf['text'] }} shadow-sm">
                <span class="font-black text-lg">{{ $conf['icon'] }}</span>
                <span class="font-black uppercase tracking-widest text-xs">{{ ucfirst($transaction->status) }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white dark:bg-[#161b22] p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-[#30363d] flex items-center gap-5 transition hover:shadow-md">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-2xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Amount Paid') }}
                        </p>
                        <p class="text-3xl font-black text-gray-900 dark:text-white mt-1">
                            {{ number_format($transaction->amount) }}
                            <span class="text-xs font-black text-gray-400 ml-1">{{ $transaction->currency }}</span>
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-[#161b22] p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-[#30363d] flex items-center gap-5 transition hover:shadow-md">
                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-2xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</p>
                        <p class="text-lg font-black text-gray-900 dark:text-white truncate mt-1">
                            {{ $transaction->user->name ?? 'Guest User' }}
                        </p>
                        <p class="text-[11px] font-bold text-gray-400 truncate">{{ $transaction->user->email ?? 'N/A' }}</p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-[#161b22] p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-[#30363d] flex items-center gap-5 transition hover:shadow-md">
                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-2xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Created At') }}</p>
                        <p class="text-lg font-black text-gray-900 dark:text-white mt-1">
                            {{ $transaction->created_at->format('H:i:s') }}
                        </p>
                        <p class="text-[11px] font-bold text-gray-400">{{ $transaction->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-[#161b22] rounded-3xl shadow-sm border border-gray-100 dark:border-[#30363d] overflow-hidden">
                        <div
                            class="px-8 py-5 border-b border-gray-50 dark:border-[#30363d] flex items-center justify-between bg-gray-50/30 dark:bg-[#1c2128]">
                            <h3 class="font-black text-sm text-gray-800 dark:text-white flex items-center gap-2 uppercase tracking-widest">
                                📦 {{ __('Products & Services') }}
                            </h3>
                            <span
                                class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 border border-blue-100 dark:border-blue-800/30">
                                {{ ucfirst($transaction->product->product_type ?? 'Unknown') }}
                            </span>
                        </div>

                        <div class="p-8">
                            <div class="flex flex-col sm:flex-row items-center gap-6 mb-8 bg-gray-50/50 dark:bg-gray-800/20 p-6 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
                                <div
                                    class="w-24 h-24 bg-white dark:bg-gray-800 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm border border-gray-100 dark:border-gray-700">
                                    @if (isset($transaction->product->image))
                                        <img src="{{ $transaction->product->image }}"
                                            class="w-full h-full object-cover rounded-2xl">
                                    @else
                                        <svg class="w-12 h-12 text-blue-500/30" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="text-center sm:text-left">
                                    <h4 class="text-2xl font-black text-gray-900 dark:text-white leading-tight">
                                        {{ $transaction->product->name ?? __('Custom product') }}
                                    </h4>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                                        {{ $transaction->description }}
                                    </p>
                                </div>
                            </div>

                            {{-- METADATA HIỂN THỊ THEO LOẠI GIAO DỊCH --}}
                            <div>
                                @php
                                    $meta = $transaction->response_data ?? [];
                                    $type = $meta['type'] ?? null;
                                    $suffix = substr($transaction->description, -1);
                                @endphp

                                {{-- === LOGIC HIỂN THỊ CHI TIẾT THEO TYPE === --}}

                                @if ($suffix === 'C' || $type === 'coinkey_deposit')
                                    <div class="bg-emerald-50/50 dark:bg-emerald-900/10 border-2 border-emerald-100/50 dark:border-emerald-800/20 rounded-2xl p-6">
                                        <div class="flex items-center gap-3 mb-5">
                                            <span class="text-2xl">💰</span>
                                            <h3 class="font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-widest text-sm text-shadow-sm">{{ __('Deposit Coinkey') }}</h3>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <span class="nk-section-label block mb-1">Số tiền:</span>
                                                <span class="font-black text-xl text-emerald-600">
                                                    {{ number_format($meta['amount'] ?? 0) }} VND
                                                </span>
                                            </div>
                                            @if (isset($meta['currency']))
                                                <div>
                                                    <span class="nk-section-label block mb-1">Phương thức:</span>
                                                    <span class="font-black text-gray-700 dark:text-gray-200">
                                                        {{ $meta['currency'] === 'wallet' ? '💳 ' . __('Wallet') : '💵 ' . __('Bank Transfer') }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                @elseif (in_array($suffix, ['K']) && $type == 'package_purchase')
                                    @if ($transaction->productKey)
                                        <div class="bg-blue-50/50 dark:bg-blue-900/10 border-2 border-blue-100/50 dark:border-blue-800/20 rounded-2xl p-6">
                                            <div class="flex items-center gap-3 mb-5">
                                                <span class="text-2xl">🔑</span>
                                                <h3 class="font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest text-sm">{{ __('Create New Key') }}</h3>
                                            </div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                                                <div>
                                                    <span class="nk-section-label block mb-1">ID Key:</span>
                                                    <a href="{{ route('admin.keys.show', $transaction->productKey->id) }}"
                                                        class="font-black text-blue-600 hover:underline">
                                                        #{{ $transaction->productKey->id }}
                                                    </a>
                                                </div>
                                                <div>
                                                    <span class="nk-section-label block mb-1">Key Code:</span>
                                                    <code class="bg-white dark:bg-gray-800 border dark:border-gray-700 px-3 py-1.5 rounded-xl font-mono text-xs font-black text-blue-600">
                                                        {{ $transaction->productKey->key_code }}
                                                    </code>
                                                </div>
                                                <div>
                                                    <span class="nk-section-label block mb-1">Thời hạn:</span>
                                                    <span class="font-black text-purple-600">
                                                        {{ number_format($meta['duration_minutes'] ?? $transaction->productKey->duration_minutes) }}
                                                        {{ __('minutes') }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="nk-section-label block mb-1">Hết hạn:</span>
                                                    <span class="font-black text-rose-500">
                                                        {{ $transaction->productKey->expires_at ? $transaction->productKey->expires_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : __('Permanent') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg-amber-50 dark:bg-amber-900/10 border-2 border-amber-100 dark:border-amber-800/20 rounded-2xl p-5">
                                            <p class="text-amber-700 dark:text-amber-400 text-xs font-bold flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                {{ __('Key not created or has been deleted') }}
                                            </p>
                                        </div>
                                    @endif

                                @elseif ($type === 'custom_key_purchase')
                                    @php
                                        $keyId = $meta['key_id'] ?? null;
                                        $key = $keyId ? \App\Models\ProductKey::find($keyId) : null;
                                    @endphp
                                    <div class="bg-purple-50/50 dark:bg-purple-900/10 border-2 border-purple-100/50 dark:border-purple-800/20 rounded-2xl p-6">
                                        <div class="flex items-center gap-3 mb-5">
                                            <span class="text-2xl">🎨</span>
                                            <h3 class="font-black text-purple-700 dark:text-purple-400 uppercase tracking-widest text-sm">Tạo Custom Key</h3>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            @if ($key)
                                                <div>
                                                    <span class="nk-section-label block mb-1">ID Key:</span>
                                                    <a href="{{ route('admin.keys.show', $key->id) }}"
                                                        class="font-black text-purple-600 hover:underline">
                                                        #{{ $key->id }}
                                                    </a>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="nk-section-label block mb-1">Key Code (Custom):</span>
                                                <code class="bg-purple-100 dark:bg-purple-900 shadow-inner px-3 py-1.5 rounded-xl font-mono text-xs font-black text-purple-700 dark:text-purple-300">
                                                    {{ $meta['key_code'] ?? 'N/A' }}
                                                </code>
                                            </div>
                                            <div>
                                                <span class="nk-section-label block mb-1">Thời hạn:</span>
                                                <span class="font-black text-gray-700 dark:text-gray-200">
                                                    {{ number_format($meta['duration_minutes'] ?? 0) }} phút
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                @elseif ($suffix === 'X' || $type === 'key_extension' || $type === 'custom_key_extension')
                                    @php
                                        $keyId = $meta['key_id'] ?? null;
                                        $key = $keyId ? \App\Models\ProductKey::find($keyId) : null;
                                        $isCustomExtension = $type === 'custom_key_extension';
                                    @endphp
                                    <div class="bg-orange-50/50 dark:bg-orange-900/10 border-2 border-orange-100/50 dark:border-orange-800/20 rounded-2xl p-6">
                                        <div class="flex items-center gap-3 mb-5">
                                            <span class="text-2xl">{{ $isCustomExtension ? '🎯' : '⏱️' }}</span>
                                            <h3 class="font-black text-orange-700 dark:text-orange-400 uppercase tracking-widest text-sm">
                                                {{ $isCustomExtension ? __('Custom Extension') : __('Extend Key') }}
                                            </h3>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            @if ($key)
                                                <div>
                                                    <span class="nk-section-label block mb-1">ID Key:</span>
                                                    <a href="{{ route('admin.keys.show', $key->id) }}"
                                                        class="font-black text-orange-600">#{{ $key->id }}</a>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="nk-section-label block mb-1">Thời gian nạp:</span>
                                                <span class="font-black text-emerald-600 text-lg">
                                                    +{{ number_format($meta['duration_minutes'] ?? 0) }} {{ __('min') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SIDEBAR INFO --}}
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-[#161b22] rounded-3xl shadow-sm border border-gray-100 dark:border-[#30363d] p-8">
                        <h4 class="nk-section-label flex items-center gap-2 mb-6">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                           {{ __('Technical Info') }}
                        </h4>
                        <ul class="space-y-6">
                            <li class="flex justify-between items-center group">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">{{ __('Order Code') }}</span>
                                <span class="font-mono font-black text-xs bg-gray-100 dark:bg-gray-800 px-3 py-1.5 rounded-xl text-gray-800 dark:text-gray-200 border border-gray-200/50 dark:border-gray-700">{{ $transaction->order_code }}</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Internal ID</span>
                                <span class="font-bold text-sm text-gray-700 dark:text-gray-300">#{{ $transaction->id }}</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Gateway</span>
                                <span class="font-black text-[10px] bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 px-2 py-1 rounded-lg uppercase border border-blue-100 dark:border-blue-800/30">{{ $transaction->payment_method ?? 'BANK' }}</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Updated</span>
                                <span class="font-bold text-xs text-gray-500">{{ $transaction->updated_at->format('d/m, H:i') }}</span>
                            </li>
                        </ul>
                    </div>

                    @if (!empty($transaction->response_data))
                        <div class="bg-[#0a0f1e] rounded-3xl shadow-2xl border border-white/5 overflow-hidden">
                            <div class="bg-white/5 px-6 py-4 flex justify-between items-center border-b border-white/5">
                                <h4 class="font-black text-white/50 text-[10px] uppercase tracking-widest">Gateway JSON Payload</h4>
                                <button onclick="copyMetadata()"
                                    class="group flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95 shadow-lg shadow-blue-500/20">
                                    <span id="copyText">Copy</span>
                                </button>
                            </div>
                            <div class="p-0">
                                <pre
                                    class="text-[11px] text-blue-300/80 font-mono overflow-x-auto whitespace-pre-wrap break-all p-8 max-h-80 custom-scrollbar bg-black/20">{{ json_encode($transaction->response_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyMetadata() {
            const data = @json($transaction->response_data);
            const jsonString = JSON.stringify(data, null, 2);
            navigator.clipboard.writeText(jsonString).then(() => {
                const btn = document.querySelector('button[onclick="copyMetadata()"]');
                const text = document.getElementById('copyText');
                const originalText = text.innerText;
                btn.classList.replace('bg-blue-600', 'bg-emerald-600');
                text.innerText = 'Copied!';
                setTimeout(() => {
                    text.innerText = originalText;
                    btn.classList.replace('bg-emerald-600', 'bg-blue-600');
                }, 2000);
            }).catch(err => console.error('Copy failed', err));
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
    </style>
</x-app-layout>