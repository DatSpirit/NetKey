<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2" />
                </svg>
            </div>
            <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">
                {{ __('Validation Statistics') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Validations -->
                <div class="bg-white dark:bg-[#161b22] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-[#30363d]">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Validations</p>
                    <p class="text-3xl font-black text-blue-600">{{ number_format($stats['total_validations']) }}</p>
                </div>

                <!-- Success -->
                <div class="bg-white dark:bg-[#161b22] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-[#30363d]">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Success</p>
                    <p class="text-3xl font-black text-green-600">{{ number_format($stats['success_validations']) }}</p>
                </div>

                <!-- Failed -->
                <div class="bg-white dark:bg-[#161b22] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-[#30363d]">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Failed</p>
                    <p class="text-3xl font-black text-red-600">{{ number_format($stats['failed_validations']) }}</p>
                </div>

                <!-- Unique IPs -->
                <div class="bg-white dark:bg-[#161b22] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-[#30363d]">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Unique IPs</p>
                    <p class="text-3xl font-black text-purple-600">{{ number_format($stats['unique_ips']) }}</p>
                </div>
            </div>

            <!-- Top Keys Table -->
            <div class="bg-white dark:bg-[#161b22] rounded-2xl shadow-sm border border-gray-100 dark:border-[#30363d] overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-[#30363d] bg-gray-50/50 dark:bg-gray-800/50">
                    <h3 class="font-bold text-gray-800 dark:text-white">Top Validated Keys</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-800 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4 font-bold">Key Code</th>
                                <th class="px-6 py-4 font-bold">Product</th>
                                <th class="px-6 py-4 font-bold text-center">Validations</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($topKeys as $key)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $key->key_code }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ $key->product->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                    {{ number_format($key->validation_logs_count) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($key->isActive())
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase">Active</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full uppercase">{{ $key->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
