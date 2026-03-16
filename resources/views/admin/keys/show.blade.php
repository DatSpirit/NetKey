<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">
                    {{ __('Key Details (View Only)') }}
                </h2>
                @if($key->trashed())
                    <span
                        class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-300 text-[10px] font-black uppercase tracking-wider rounded-full border border-red-200 dark:border-red-800">
                        {{ __('DELETED') }}
                    </span>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.keys.index') }}"
                    class="px-4 py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-bold rounded-xl hover:bg-gray-200 transition-all duration-200 text-xs uppercase tracking-wider">
                    ← {{ __('Go Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">

        {{-- Key Info Card --}}
        <div class="bg-white dark:bg-[#161b22] shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-[#30363d] mb-6">

            <div class="bg-[#0a0f1e] p-6 border-b border-white/5">
                <h3 class="text-xl font-black text-white flex items-center gap-2">
                    🔑 {{ __('Key Information') }}
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                <div class="p-5 bg-gray-50/50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm transition-all duration-200 hover:shadow-md">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-wider mb-2">Key Code</p>
                    <p class="font-mono text-xl font-black text-blue-600 dark:text-blue-400 select-all break-all">
                        {{ $key->key_code }}
                    </p>
                </div>

                <div class="p-5 bg-gray-50/50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm transition-all duration-200 hover:hover:shadow-md">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-wider mb-2">{{ __('Status') }}
                    </p>
                    @if ($key->status == 'active')
                        <span
                            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 text-[10px] font-black uppercase tracking-wider rounded-full border border-green-100 dark:border-green-900/30">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                            Active
                        </span>
                    @elseif($key->status == 'expired')
                        <span
                            class="px-4 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-wider rounded-full border border-gray-200 dark:border-gray-600">
                            Expired
                        </span>
                    @elseif($key->status == 'suspended')
                        <span
                            class="px-4 py-1.5 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-[10px] font-black uppercase tracking-wider rounded-full border border-amber-100 dark:border-amber-900/30">
                            Suspended
                        </span>
                    @else
                        <span
                            class="px-4 py-1.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-[10px] font-black uppercase tracking-wider rounded-full border border-red-100 dark:border-red-900/30">
                            {{ ucfirst($key->status) }}
                        </span>
                    @endif
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">
                        {{ __('Key Type') }}
                    </p>
                    @if($key->key_type == 'custom')
                        <span
                            class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-lg text-sm font-semibold">
                            ✨ Custom
                        </span>
                    @else
                        <span
                            class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-semibold">
                            📦 Auto
                        </span>
                    @endif
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">{{ __('Owner') }}
                    </p>
                    <p class="font-semibold text-gray-800 dark:text-white">
                        {{ $key->user->name ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $key->user->email ?? 'N/A' }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">
                        {{ __('Activation Date') }}
                    </p>
                    @if($key->activated_at)
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $key->activated_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $key->activated_at->diffForHumans() }}</p>
                    @else
                        <p class="text-gray-500">{{ __('Not activated') }}</p>
                    @endif
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">
                        {{ __('Expiration Date') }}
                    </p>
                    @if ($key->expires_at)
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $key->expires_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-sm {{ $key->isExpired() ? 'text-red-500' : 'text-green-600' }}">
                            {{ $key->expires_at->diffForHumans() }}
                        </p>
                    @else
                        <p class="text-lg font-bold text-blue-600">∞ {{ __('Permanent') }}</p>
                    @endif
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">
                        {{ __('Duration') }}
                    </p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ number_format($key->duration_minutes) }}
                        {{ __('minutes') }}
                    </p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">{{ __('Cost') }}
                    </p>
                    <p class="font-bold text-yellow-600 dark:text-yellow-400">{{ number_format((float)($key->key_cost ?? 0)) }} 🪙</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">
                        {{ __('Validations') }}
                    </p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ number_format($key->validation_count) }}
                    </p>
                </div>

                @if($key->assigned_to_email)
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">
                            {{ __('Assigned to') }}
                        </p>
                        <p class="font-semibold text-gray-800 dark:text-white">{{ $key->assigned_to_email }}</p>
                    </div>
                @endif

                @if($key->deleted_at)
                    <div
                        class="col-span-full p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <p class="text-xs text-red-500 dark:text-red-400 uppercase font-semibold mb-1">
                            {{ __('Deleted Date') }}
                        </p>
                        <p class="font-semibold text-red-600 dark:text-red-400">
                            {{ $key->deleted_at->format('d/m/Y H:i:s') }}
                        </p>
                    </div>
                @endif

            </div>

            @if($key->notes)
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-xs text-blue-600 dark:text-blue-400 uppercase font-semibold mb-2">{{ __('Notes') }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $key->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Validation Stats --}}
        <div class="bg-white dark:bg-[#161b22] shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-[#30363d] mb-6">
            <div class="bg-[#0a0f1e] p-6 border-b border-white/5">
                <h3 class="text-xl font-black text-white flex items-center gap-2">
                    📊 {{ __('Validation Statistics') }}
                </h3>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="nk-stat-card">
                    <div class="nk-stat-accent-stripe !bg-blue-500"></div>
                    <p class="nk-stat-label">{{ __('Total') }}</p>
                    <p class="nk-stat-value">
                        {{ number_format($validationStats['total_validations']) }}
                    </p>
                </div>

                <div class="nk-stat-card">
                    <div class="nk-stat-accent-stripe stripe-green"></div>
                    <p class="nk-stat-label">{{ __('Success') }}</p>
                    <p class="nk-stat-value !text-green-600 dark:!text-green-400">
                        {{ number_format($validationStats['success_count']) }}
                    </p>
                </div>

                <div class="nk-stat-card">
                    <div class="nk-stat-accent-stripe stripe-red"></div>
                    <p class="nk-stat-label">{{ __('Failed') }}</p>
                    <p class="nk-stat-value !text-red-600 dark:!text-red-400">
                        {{ number_format($validationStats['failed_count']) }}
                    </p>
                </div>

                <div class="nk-stat-card">
                    <div class="nk-stat-accent-stripe !bg-purple-500"></div>
                    <p class="nk-stat-label">{{ __('Unique IPs') }}</p>
                    <p class="nk-stat-value !text-purple-600 dark:!text-purple-400">
                        {{ number_format($validationStats['unique_ips']) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Recent Validations --}}
        <div class="bg-white dark:bg-[#161b22] shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-[#30363d]">
            <div class="bg-[#0a0f1e] p-6 border-b border-white/5">
                <h3 class="text-xl font-black text-white flex items-center gap-2">
                    🕒 {{ __('Recent Validation History') }}
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[2px] opacity-70">{{ __('IP Address') }}</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[2px] opacity-70">{{ __('Device Info') }}</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[2px] opacity-70">{{ __('Result') }}</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[2px] opacity-70">{{ __('Time') }}</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentValidations as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3 font-mono text-xs">{{ $log->ip_address }}</td>
                                <td class="px-4 py-3 text-xs">{{ Str::limit($log->device_info, 50) }}</td>
                                <td class="px-4 py-3">
                                    @if ($log->validation_result == 'success')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded font-semibold">
                                            ✓ Success
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded font-semibold">
                                            ✗ {{ ucfirst($log->validation_result) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400">
                                    {{ $log->validated_at->format('d/m/Y H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                    {{ __('No validation history yet') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>