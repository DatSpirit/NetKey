<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">🎫 Support Tickets</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</div>
                <div class="text-gray-500 text-sm">Tổng tickets</div>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4 border border-yellow-200 dark:border-yellow-700/50">
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['open'] }}</div>
                <div class="text-gray-500 text-sm">Đang mở</div>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-700/50">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['in_progress'] }}</div>
                <div class="text-gray-500 text-sm">Đang xử lý</div>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-700/50">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['closed'] }}</div>
                <div class="text-gray-500 text-sm">Đã đóng</div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 mb-4 shadow-sm">
            <form method="GET" class="flex gap-3 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Tìm theo email, tên, tiêu đề..."
                    class="flex-1 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-48">
                <select name="status" class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 border border-gray-300 dark:border-gray-600 focus:outline-none">
                    <option value="">Tất cả trạng thái</option>
                    <option value="open" @selected(request('status') === 'open')>Đang mở</option>
                    <option value="in_progress" @selected(request('status') === 'in_progress')>Đang xử lý</option>
                    <option value="closed" @selected(request('status') === 'closed')>Đã đóng</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">Lọc</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('admin.support.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">Reset</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-900 text-white">
                    <tr>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">#</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">Người gửi</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">Tiêu đề</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">Trạng thái</th>
                        <th class="px-4 py-3 text-xs font-black uppercase tracking-widest opacity-70">Thời gian</th>
                        <th class="px-4 py-3 text-right text-xs font-black uppercase tracking-widest opacity-70">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($tickets as $ticket)
                    <tr class="hover:bg-blue-50/30 dark:hover:bg-gray-700/40 transition">
                        <td class="px-4 py-3 text-gray-400">{{ $ticket->id }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900 dark:text-white">{{ $ticket->name }}</div>
                            <div class="text-gray-400 dark:text-gray-500 text-xs">{{ $ticket->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-200 max-w-xs truncate">{{ $ticket->subject }}</td>
                        <td class="px-4 py-3">
                            @php
                                $badge = match($ticket->status) {
                                    'open'        => 'bg-yellow-100 text-yellow-700 border-yellow-300 dark:bg-yellow-500/20 dark:text-yellow-400 dark:border-yellow-500/30',
                                    'in_progress' => 'bg-blue-100 text-blue-700 border-blue-300 dark:bg-blue-500/20 dark:text-blue-400 dark:border-blue-500/30',
                                    'closed'      => 'bg-green-100 text-green-700 border-green-300 dark:bg-green-500/20 dark:text-green-400 dark:border-green-500/30',
                                    default       => 'bg-gray-100 text-gray-500',
                                };
                                $label = match($ticket->status) {
                                    'open'        => 'Đang mở',
                                    'in_progress' => 'Đang xử lý',
                                    'closed'      => 'Đã đóng',
                                    default       => $ticket->status,
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs border {{ $badge }}">{{ $label }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-400 dark:text-gray-500 text-xs">{{ $ticket->created_at->format('H:i d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.support.show', $ticket) }}"
                               class="px-3 py-1 bg-blue-100 hover:bg-blue-200 dark:bg-blue-600/20 dark:hover:bg-blue-600/40 text-blue-700 dark:text-blue-400 rounded text-xs transition inline-flex items-center gap-1">
                                🔍 Xem
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                            <div class="text-4xl mb-2">📭</div>
                            Chưa có ticket nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($tickets->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $tickets->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
