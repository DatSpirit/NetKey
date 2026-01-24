<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2
                class="font-black text-3xl bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 flex items-center gap-3">
                Lịch Điểm Danh Tháng {{ $calendar['month'] }}/{{ $calendar['year'] }}
            </h2>
            <div
                class="flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-4 py-2 rounded-full shadow-sm">
                <span>Hôm nay: {{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto space-y-8">

            <!-- Hero Summary Card -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-[2rem] shadow-2xl p-8 sm:p-10 text-white transform hover:scale-[1.01] transition-transform duration-300">
                <!-- Background Decorations -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-yellow-300 opacity-20 rounded-full blur-2xl">
                </div>

                <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-8">
                    <div class="flex items-center gap-6">
                        <div class="p-4 bg-white/20 backdrop-blur-md rounded-2xl shadow-inner border border-white/10">
                            <span class="text-5xl">📅</span>
                        </div>
                        <div>
                            <p class="text-indigo-100 text-lg font-medium mb-1">Tổng Coinkey Tháng Này</p>
                            <h3 class="text-5xl font-black tracking-tight text-white drop-shadow-md">
                                {{ number_format(collect($calendar['days'])->where('status', 'checked')->sum('reward')) }}
                                <span class="text-2xl opacity-80 font-bold">Coinkey</span>
                            </h3>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="text-center px-6 py-4 bg-black/20 backdrop-blur-sm rounded-2xl border border-white/10 hover:bg-black/30 transition">
                            <p class="text-xs text-indigo-200 uppercase tracking-widest font-bold mb-1">Đã điểm danh</p>
                            <p class="text-3xl font-black">
                                {{ collect($calendar['days'])->where('status', 'checked')->count() }}
                                <span class="text-sm text-indigo-200 font-normal">/
                                    {{ count($calendar['days']) }}</span>
                            </p>
                        </div>
                        <div
                            class="text-center px-6 py-4 bg-white/20 backdrop-blur-sm rounded-2xl border border-white/10 hover:bg-white/30 transition">
                            <p class="text-xs text-indigo-100 uppercase tracking-widest font-bold mb-1">Chuỗi hiện tại
                            </p>
                            <!-- Note: Streak calculation would need to be passed strictly if accurate streak display is needed here, 
                                 but for monthly view visual summary we can just show a placeholder or calculate loosely -->
                            <p class="text-3xl font-black">🔥
                                {{ collect($calendar['days'])->where('status', 'checked')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Container -->
            <div
                class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">

                <!-- Days of Week Header -->
                <div
                    class="grid grid-cols-7 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    @foreach(['Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'] as $index => $day)
                        <div class="py-4 text-center">
                            <span
                                class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 bg-gray-100 dark:bg-gray-700 gap-px">

                    <!-- Empty Cells -->
                    @for($i = 0; $i < $calendar['start_day_of_week']; $i++)
                        <div class="bg-white dark:bg-gray-800 h-32 sm:h-40"></div>
                    @endfor

                    @foreach($calendar['days'] as $day)
                        <div class="relative bg-white dark:bg-gray-800 h-32 sm:h-40 p-3 transition-all duration-200 group hover:z-10 hover:shadow-lg
                                                            {{ $day['is_today'] ? 'bg-blue-500/30 dark:bg-blue-900/10' : '' }}
                                                            {{ $day['special_day'] ? 'bg-gradient-to-br from-yellow-500 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10' : '' }}
                                                        ">
                            <!-- Date Number -->
                            <div class="flex justify-between items-start">
                                <span
                                    class="text-sm font-bold w-8 h-8 flex items-center justify-center rounded-full transition-colors
                                                                    {{ $day['is_today'] ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-700 dark:text-gray-300 group-hover:bg-gray-100 dark:group-hover:bg-gray-700' }}">
                                    {{ $day['day'] }}
                                </span>

                                @if($day['special_day'])
                                    <div class="group/tooltip relative">
                                        <span
                                            class="text-xl cursor-help hover:scale-125 transition-transform duration-200">🎉</span>
                                        <div
                                            class="absolute right-0 top-full mt-1 w-max px-2 py-1 bg-black text-white text-xs rounded opacity-0 group-hover/tooltip:opacity-100 transition-opacity z-20 pointer-events-none">
                                            {{ $day['special_day']['name'] }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Content State -->
                            <div class="flex flex-col items-center justify-center h-full -mt-6">

                                @if($day['status'] === 'checked')
                                    <!-- Checked State -->
                                    <div class="transform group-hover:scale-110 transition-transform duration-200">
                                        <div
                                            class="w-12 h-12 bg-green-100 dark:bg-green-600/30 rounded-full flex items-center justify-center mb-1">
                                            <span class="text-2xl">✅</span>
                                        </div>
                                    </div>
                                    <span
                                        class="font-bold text-green-600 dark:text-green-400 text-sm drop-shadow-sm">+{{ $day['reward'] }}
                                        CoinKey</span>

                                @elseif($day['status'] === 'missed')
                                    <!-- Missed State -->
                                    <div class="opacity-50 grayscale hover:grayscale-0 transition-all duration-300">
                                        <div
                                            class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-1 mx-auto">
                                            <span class="text-xl">😿</span>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-400">Đã lỡ</span>
                                    </div>

                                @elseif($day['status'] === 'today')
                                    <!-- Today (Actionable) -->
                                    <div class="animate-bounce-slow">
                                        <button onclick="checkin()" id="checkin-btn"
                                            class="flex flex-col items-center justify-center gap-1 group/btn w-full">
                                            <div
                                                class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover/btn:scale-110 group-active/btn:scale-95 transition-all duration-200 border-2 border-blue-200 dark:border-blue-700">
                                                <span class="text-2xl">👆</span>
                                            </div>
                                            <span
                                                class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full shadow-md group-hover/btn:bg-blue-700 transition">
                                                Nhận {{ $day['reward'] }}
                                            </span>
                                        </button>
                                    </div>

                                @else
                                    <!-- Future -->
                                    <div
                                        class="opacity-40 hover:opacity-100 transition-opacity duration-300 flex flex-col items-center">
                                        <div
                                            class="w-10 h-10 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-full flex items-center justify-center mb-1">
                                            <span class="text-base">⏳</span>
                                        </div>
                                        <span class="text-xs font-medium text-gray-500">+{{ $day['reward'] }}</span>
                                    </div>
                                @endif

                            </div>

                            <!-- Special Badge for Future/Missed if Special Day -->
                            @if($day['special_day'] && $day['status'] !== 'checked')
                                <div class="absolute bottom-1 right-1">
                                    <span
                                        class="px-1.5 py-0.5 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 text-[10px] font-bold uppercase rounded border border-yellow-200 dark:border-yellow-800">
                                        Bonus x{{ $day['special_day']['multiplier'] }}
                                    </span>
                                </div>
                            @endif

                        </div>
                    @endforeach

                    <!-- Fill remaining cells -->
                    @php
                        $totalCells = $calendar['start_day_of_week'] + count($calendar['days']);
                        $remaining = 7 - ($totalCells % 7);
                        if ($remaining == 7)
                            $remaining = 0;
                    @endphp
                    @for($i = 0; $i < $remaining; $i++)
                        <div class="bg-white dark:bg-gray-800 h-32 sm:h-40 opacity-50 bg-diagonal-stripes"></div>
                    @endfor

                </div>
            </div>

            <!-- Legend/Footer -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                <div
                    class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-2xl">✅</span>
                    <div>
                        <p class="font-bold text-gray-800 dark:text-white">Đã nhận</p>
                        <p class="text-xs text-gray-500">Coinkey đã được cộng</p>
                    </div>
                </div>
                <div
                    class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-2xl">😿</span>
                    <div>
                        <p class="font-bold text-gray-800 dark:text-white">Bỏ lỡ</p>
                        <p class="text-xs text-gray-500">Không điểm danh</p>
                    </div>
                </div>
                <div
                    class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-2xl">🎉</span>
                    <div>
                        <p class="font-bold text-gray-800 dark:text-white">Sự kiện</p>
                        <p class="text-xs text-gray-500">Ngày lễ thưởng lớn</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            async function checkin() {
                const btn = document.getElementById('checkin-btn');
                if (!btn) return;

                // Disable button logic
                const originalContent = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = `<div class="animate-spin w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full"></div>`;
                btn.classList.add('cursor-not-allowed', 'opacity-75');

                try {
                    const response = await fetch('{{ route("checkin.process") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Success State
                        btn.innerHTML = `
                                                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg transform scale-110 transition-transform">
                                                            <span class="text-white text-2xl">✓</span>
                                                        </div>
                                                    `;

                        // Confetti or simple visual feedback could go here

                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        alert(data.message);
                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                        btn.classList.remove('cursor-not-allowed', 'opacity-75');
                    }
                } catch (error) {
                    console.error(error);
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    btn.classList.remove('cursor-not-allowed', 'opacity-75');
                }
            }
        </script>
        <style>
            .animate-bounce-slow {
                animation: bounce 2s infinite;
            }

            @keyframes bounce {

                0%,
                100% {
                    transform: translateY(-5%);
                    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
                }

                50% {
                    transform: translateY(0);
                    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
                }
            }

            .bg-diagonal-stripes {
                background-image: linear-gradient(135deg, #f3f4f6 25%, transparent 25%, transparent 50%, #f3f4f6 50%, #f3f4f6 75%, transparent 75%, transparent);
                background-size: 10px 10px;
            }
        </style>
    @endpush
</x-app-layout>