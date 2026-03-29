<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">{{ __('Admin Audit Log') }}</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">{{ __('History of all administrator actions on the system') }}
        </p>

        {{-- Filter --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 mb-4 shadow-sm">
            <form method="GET" class="flex gap-3 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by description, IP...') }}"
                    class="flex-1 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-48">
                <select name="action"
                    class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 border border-gray-300 dark:border-gray-600 focus:outline-none">
                    <option value="">{{ __('All Actions') }}</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" @selected(request('action') === $action)>{{ $action }}</option>
                    @endforeach
                </select>
                <input type="date" name="date" value="{{ request('date') }}"
                    class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 border border-gray-300 dark:border-gray-600 focus:outline-none">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">{{ __('Filter') }}</button>
                @if(request()->hasAny(['search', 'action', 'date']))
                    <a href="{{ route('admin.audit-log') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">{{ __('Reset') }}</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-900 text-white">
                    <tr>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">{{ __('Time') }}</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">{{ __('Admin') }}</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">{{ __('Action') }}</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">{{ __('Target') }}</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">{{ __('Description') }}</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-blue-50/30 dark:hover:bg-gray-700/30 transition">
                            <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
                                {{ $log->created_at->format('H:i d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 dark:text-white text-sm">{{ $log->admin->name ?? 'N/A' }}</div>
                                <div class="text-gray-500 text-xs">{{ $log->admin->email ?? '' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $actionColor = match (true) {
                                        str_contains($log->action, 'delete') || str_contains($log->action, 'revoke') => 'text-red-600 bg-red-50 dark:text-red-400 dark:bg-red-500/10',
                                        str_contains($log->action, 'suspend') => 'text-yellow-600 bg-yellow-50 dark:text-yellow-400 dark:bg-yellow-500/10',
                                        str_contains($log->action, 'activate') || str_contains($log->action, 'extend') => 'text-green-600 bg-green-50 dark:text-green-400 dark:bg-green-500/10',
                                        default => 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-500/10',
                                    };
                                @endphp
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-mono {{ $actionColor }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">
                                @if($log->target_type)
                                    <span class="text-gray-700 dark:text-gray-300">{{ $log->target_type }}</span>
                                    @if($log->target_id) <span class="text-gray-400">#{{ $log->target_id }}</span> @endif
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300 max-w-xs">{{ $log->description }}</td>
                            <td class="px-4 py-3 text-gray-400 text-xs font-mono">{{ $log->ip_address ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                <div class="text-4xl mb-2">📋</div>
                                {{ __('No action logs found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($logs->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">{{ $logs->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>