<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.support.index') }}"
               class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="p-2 bg-blue-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
            </div>
            <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">Ticket #{{ $ticket->id }}</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            {{-- Header --}}
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ $ticket->created_at->format('H:i:s d/m/Y') }}</p>
                </div>

                {{-- Cập nhật trạng thái --}}
                <form method="POST" action="{{ route('admin.support.update-status', $ticket) }}" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()"
                        class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="open" @selected($ticket->status === 'open')>Đang mở</option>
                        <option value="in_progress" @selected($ticket->status === 'in_progress')>Đang xử lý</option>
                        <option value="closed" @selected($ticket->status === 'closed')>Đã đóng</option>
                    </select>
                </form>
            </div>

            {{-- Thông tin người gửi --}}
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-400 text-xs uppercase font-semibold mb-1">Người gửi</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $ticket->name }}</p>
                    <p class="text-blue-600 dark:text-blue-400 text-sm">{{ $ticket->email }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase font-semibold mb-1">Tài khoản</p>
                    @if($ticket->user)
                        <p class="text-gray-900 dark:text-white">User #{{ $ticket->user->id }} — {{ $ticket->user->name }}</p>
                    @else
                        <p class="text-gray-400 italic">Khách vãng lai</p>
                    @endif
                </div>
                @if($ticket->ip_address)
                <div>
                    <p class="text-gray-400 text-xs uppercase font-semibold mb-1">IP Address</p>
                    <p class="text-gray-600 dark:text-gray-300 font-mono text-sm">{{ $ticket->ip_address }}</p>
                </div>
                @endif
                <div>
                    <p class="text-gray-400 text-xs uppercase font-semibold mb-1">Trạng thái</p>
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
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs border {{ $badge }}">{{ $label }}</span>
                </div>
            </div>

            {{-- Tiêu đề --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-gray-400 text-xs uppercase font-semibold mb-1">Tiêu đề</p>
                <p class="text-gray-900 dark:text-white text-lg font-medium">{{ $ticket->subject }}</p>
            </div>

            {{-- Nội dung --}}
            <div class="px-6 py-5">
                <p class="text-gray-400 text-xs uppercase font-semibold mb-3">Nội dung yêu cầu</p>
                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 text-gray-700 dark:text-gray-200 text-sm leading-relaxed whitespace-pre-wrap">{{ $ticket->message }}</div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <a href="mailto:{{ $ticket->email }}?subject=Re: {{ $ticket->subject }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm transition inline-flex items-center gap-2">
                    ✉️ Reply via Email
                </a>
                <span class="text-gray-400 text-xs">Ticket ID: #{{ $ticket->id }}</span>
            </div>
        </div>
    </div>
</x-app-layout>
