@push('styles')
<style>
/* ── HELP CENTER — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Backgrounds */
.bg-gray-50.dark\:bg-gray-900 {
    background: var(--bg-app) !important;
}
.bg-gray-50.dark\:bg-gray-700\/50,
.bg-gray-100.dark\:bg-gray-700 {
    background: var(--bg-layer) !important;
    border-color: var(--border) !important;
}

/* Search Input */
input.bg-gray-100.dark\:bg-gray-700 {
    background: var(--bg-inner) !important;
    color: var(--text-color) !important;
    border: 1px solid var(--border) !important;
}
input:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 1px #2563eb !important;
}

/* Highlights */
.text-indigo-600, .dark\:text-indigo-400,
.text-indigo-500 { color: #2563eb !important; }
.bg-indigo-600 { background-color: #2563eb !important; }
.hover\:text-indigo-500:hover, .dark\:hover\:text-indigo-300:hover { color: #1d4ed8 !important; }

/* Details/Summary overrides */
details > summary { list-style: none; }
details > summary::-webkit-details-marker { display: none; }
details[open] summary ~ * { animation: sweep .3s ease-in-out; }

@keyframes sweep {
  0%    {opacity: 0; transform: translateY(-10px)}
  100%  {opacity: 1; transform: translateY(0)}
}
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 dark:text-white flex items-center">
            <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ __('Help Center') }} & {{ __('FAQ') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-8rem)]">
        <div class="max-w-4xl mx-auto space-y-10">

            {{-- Thanh tìm kiếm --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 dark:bg-indigo-900/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

                <div class="relative z-10 text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Hello, how can we help you?') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Search for answers to common questions below.') }}</p>
                </div>

                <form action="#" method="GET" class="relative z-10 max-w-2xl mx-auto">
                    <div class="relative group">
                        <input type="search" placeholder="{{ __('Enter keyword, e.g: create order, payment error...') }}"
                            class="w-full py-4 pl-14 pr-6 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-lg text-gray-900 dark:text-white shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-500 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Danh sách Câu hỏi Thường gặp (FAQ) --}}
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/40 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('Frequently Asked Questions') }}
                    </h3>
                </div>

                <div class="grid gap-4">
                    @foreach ($faqs as $faq)
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden group">
                            <details class="group-details">
                                <summary
                                    class="flex justify-between items-center cursor-pointer p-5 sm:p-6 list-none hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-200 outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:bg-gray-50 dark:focus-visible:bg-gray-700/50">
                                    <span class="text-lg font-bold text-gray-800 dark:text-gray-100 pr-6">
                                        {{ $faq['question'] }}
                                    </span>
                                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/30 transition-colors">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-details-open:rotate-180 group-details-open:text-indigo-600 dark:group-details-open:text-indigo-400 transition-all duration-300 transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <div
                                    class="px-5 sm:px-6 pb-6 pt-2 text-base text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-700/50">
                                    <p>{{ $faq['answer'] }}</p>
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>

                {{-- Liên kết đến trang liên hệ --}}
                <div class="mt-12 text-center bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl p-8 border border-indigo-100 dark:border-indigo-800/30">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-100 dark:bg-indigo-800 rounded-full mb-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Still need help?') }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('If you cannot find the answer to your question, feel free to contact us.') }}</p>
                    <a href="{{ route('support.contact') }}"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Contact our support team') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>