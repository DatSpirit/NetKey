<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        {{ __('My Wallet') }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('Manage your balance and Coinkey transactions') }}
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('products') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition-all shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        {{ __('Top Up Coinkey') }}
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Main Balance Card -->
                <div
                    class="lg:col-span-2 relative overflow-hidden bg-gradient-to-r from-blue-400 to-blue-200 rounded-2xl shadow-xl p-8 text-white">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-indigo-400 opacity-20 rounded-full blur-2xl">
                    </div>

                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div>
                            <p
                                class="text-gray-900 dark:text-blue-200 font-medium text-sm uppercase tracking-wider mb-2">
                                {{ __('Current Balance') }}
                            </p>
                            <div class="flex items-baseline gap-2">
                                <span
                                    class="text-5xl text-gray-900 dark:text-gray-100 font-extrabold tracking-tight">{{ number_format($wallet->balance) }}</span>
                                <span class="text-xl font-semibold text-blue-800">Coinkey</span>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-8 border-t border-white/20 pt-6">
                            <div>
                                <p class="text-gray-900 dark:text-gray-100 text-xs uppercase mb-1">
                                    {{ __('Total Deposits') }}
                                </p>
                                <p class="text-xl text-blue-600 dark:text-blue-800 font-bold">
                                    {{ number_format($wallet->total_deposited) }} <span
                                        class="text-xs text-black dark:text-blue-800 font-normal opacity-70">{{ $userCurrency ?? 'VND' }}</span>
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-gray-100 text-xs uppercase mb-1">
                                    {{ __('Total Spent') }}
                                </p>
                                <p class="text-xl text-blue-600 dark:text-blue-800 font-bold">
                                    {{ number_format($wallet->total_spent) }} <span
                                        class="text-xs text-black dark:text-blue-800 font-normal opacity-70">Coinkey</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions / Promo -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex flex-col justify-center">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </span>
                        {{ __('Featured Services') }}
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('products', ['open_custom_modal' => 'true']) }}"
                            class="block p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition group">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">
                                        {{ __('Create Custom Key') }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ __('Choose your usage time') }}</p>
                                </div>
                                <span class="text-gray-400 group-hover:text-indigo-600 transition">→</span>
                            </div>
                        </a>
                        <a href="{{ route('wallet.buy-package') }}"
                            class="block p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition group">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">
                                        {{ __('Buy Package & Extend Account') }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ __('Save up to 30%') }}</p>
                                </div>
                                <span class="text-gray-400 group-hover:text-indigo-600 transition">→</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Transaction History Section -->
            <div x-data="{ activeTab: '{{ request('tab', 'wallet_log') }}' }"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex -mb-px px-6" aria-label="Tabs">
                        <button @click="activeTab = 'wallet_log'" :class="activeTab === 'wallet_log' ? 'border-indigo-500 text-indigo-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            {{ __('Balance Changes (Coins)') }}
                        </button>
                        <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'border-indigo-500 text-indigo-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            {{ __('Order History (Cash)') }}
                        </button>
                    </nav>
                </div>

                <!-- Chart Section -->
                <div
                    class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 hidden md:block">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Balance changes last 30 days') }}
                    </h3>
                    <div class="relative h-64 w-full">
                        <canvas id="balanceChart"></canvas>
                    </div>
                </div>

                <!-- Tab Content: Wallet Logs (Coinkey Transactions) -->
                <div x-show="activeTab === 'wallet_log'" class="p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('Time') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('Content') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('Quantity') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('Final Balance') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($walletTransactions ?? [] as $log)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col">
                                                <span class="font-medium text-gray-900 dark:text-gray-200">
                                                    {{ $log->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-500">
                                                    {{ $log->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <span
                                                    class="p-1.5 rounded-full mr-3 shrink-0 {{ $log->amount > 0 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                                    @if ($log->amount > 0)
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                                        </svg>
                                                    @endif
                                                </span>
                                                <span
                                                    class="text-sm font-medium text-gray-900 dark:text-white break-words">{{ $log->description }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <span
                                                class="text-sm font-bold font-mono {{ $log->amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $log->amount > 0 ? '+' : '' }}{{ number_format($log->amount) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                            {{ number_format($log->balance_after) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                            Chưa có biến động số dư nào.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (isset($walletTransactions) && method_exists($walletTransactions, 'links'))
                        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            {{ $walletTransactions->appends(['tab' => 'wallet_log'])->links() }}
                        </div>
                    @endif
                </div>

                <!-- Tab Content: Orders (PayOS Transactions) -->
                <div x-show="activeTab === 'orders'" class="p-0" style="display: none;">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mã đơn
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Thời gian
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sản phẩm
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Số tiền
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Trạng thái
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($transactions ?? [] as $tx)
                                    @php
                                        $meta = $tx->response_data ?? [];
                                        $type = $meta['type'] ?? '';
                                        $desc = $tx->description ?? '';
                                        $productType = $tx->product->product_type ?? '';

                                        // LOGIC SUFFIX CHÍNH XÁC
                                        $suffix = '';
                                        $badgeClass = 'bg-gray-100 text-gray-600 border-gray-200'; // Default
                                        $badgeText = '';

                                        // 1. AC - Account Extension
                                        $isExtension = $meta['is_extension'] ?? false;
                                        if ($isExtension || str_contains($desc, 'Gia Hạn') || str_contains($desc, 'Account Extension') || $type === 'package_extension') {
                                            $suffix = 'AC';
                                            $badgeClass = 'bg-indigo-100 text-indigo-700 border-indigo-200';
                                            $badgeText = 'AC';
                                        }
                                        // 2. CEX - Custom Extension (Check BEFORE EX)
                                        elseif ($type === 'custom_key_extension' || substr($desc, -3) === 'CEX') {
                                            $suffix = 'CEX';
                                            $badgeClass = 'bg-orange-100 text-orange-700 border-orange-200';
                                            $badgeText = 'CEX';
                                        }
                                        // 3. EX - Key Extension
                                        elseif ($type === 'key_extension' || substr($desc, -2) === 'EX') {
                                            $suffix = 'EX';
                                            $badgeClass = 'bg-green-100 text-green-700 border-green-200';
                                            $badgeText = 'EX';
                                        }
                                        // 4. K - Key
                                        elseif (($productType === 'package' && !$type) || substr($desc, -1) === 'K' || $type === 'package_purchase') {
                                            $suffix = 'K';
                                            $badgeClass = 'bg-blue-100 text-blue-700 border-blue-200';
                                            $badgeText = 'K';
                                        }
                                        // 5. C - Coinkey
                                        elseif ($productType === 'coinkey' || substr($desc, -1) === 'C') {
                                            $suffix = 'C';
                                            $badgeClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                                            $badgeText = 'C';
                                        }

                                        // Append explicit suffix just for display if not present
                                        $displayOrderCode = $tx->order_code;
                                        if ($suffix && !str_ends_with($displayOrderCode, $suffix)) {
                                            $displayOrderCode .= $suffix;
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-bold font-mono text-gray-900 dark:text-gray-100">
                                                    #{{ $displayOrderCode }}
                                                </span>
                                                @if($badgeText)
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold border {{ $badgeClass }}">
                                                        {{ $badgeText }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="text-sm text-gray-900 dark:text-gray-200">
                                                    {{ $tx->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $tx->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                            <div class="flex flex-col">
                                                <span class="font-medium text-gray-900 dark:text-gray-100 line-clamp-1">
                                                    {{ $tx->product->name ?? $tx->description }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ Str::limit($tx->description, 20) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-right whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                            {{ number_format($tx->amount) }}
                                            <span class="text-xs font-normal text-gray-500">{{ $tx->currency }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if ($tx->status == 'success')
                                                <span
                                                    class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                    Thành công
                                                </span>
                                            @elseif($tx->status == 'pending')
                                                <span
                                                    class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    Chờ xử lý
                                                </span>
                                            @else
                                                <span
                                                    class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                    Thất bại
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                            Chưa có giao dịch mua hàng nào.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (isset($transactions) && method_exists($transactions, 'links'))
                        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            {{ $transactions->appends(['tab' => 'orders'])->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chart.js CDN -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Chart Logic
                    const ctx = document.getElementById('balanceChart');
                    if (ctx) {
                        // Prepare data from PHP variable $walletTransactions (needs detailed data passed to JS)
                        // This is a simplified example using transaction amounts to derive balance history relative to current

                        const transactions = @json($walletTransactions->items());
                        const currentBalance = {{ $wallet->balance }};

                        // Process data for chart (Reverse order for timeline: Old -> New)
                        const chartData = transactions.slice().reverse().map(tx => {
                            return {
                                x: new Date(tx.created_at).toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' }),
                                y: tx.balance_after
                            };
                        });

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: chartData.map(d => d.x),
                                datasets: [{
                                    label: 'Số dư (Coinkey)',
                                    data: chartData.map(d => d.y),
                                    borderColor: '#4f46e5', // indigo-600
                                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.3, // smooth curve
                                    fill: true,
                                    pointBackgroundColor: '#fff',
                                    pointBorderColor: '#4f46e5',
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false,
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                },
                                interaction: {
                                    mode: 'nearest',
                                    axis: 'x',
                                    intersect: false
                                }
                            }
                        });
                    }
                });
            </script>

        </div>
    </div>
</x-app-layout>