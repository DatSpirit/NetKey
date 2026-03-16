@push('styles')
<style>
/* ── CONTACT SUPPORT — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Backgrounds */
.bg-gray-50.dark\:bg-gray-900 {
    background: var(--bg-app) !important;
}
.bg-gray-50.dark\:bg-gray-700 {
    background: var(--bg-elevated) !important;
    border-color: var(--border) !important;
}

/* Form Inputs */
input.bg-gray-50.dark\:bg-gray-700, 
textarea.bg-gray-50.dark\:bg-gray-700 {
    background: var(--bg-layer) !important;
    border: 1px solid var(--border) !important;
    color: var(--text-color) !important;
}
input:focus, textarea:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 1px #2563eb !important;
}

/* Highlights & Buttons */
.text-indigo-600, .dark\:text-indigo-400 { color: #2563eb !important; }
.bg-indigo-600 { background-color: #2563eb !important; }
.hover\:bg-indigo-700:hover { background-color: #1d4ed8 !important; }

/* Alerts */
.bg-green-100 { background-color: rgba(16, 185, 129, 0.15) !important; color: #10b981 !important; border-color: rgba(16, 185, 129, 0.3) !important;}
.bg-red-100 { background-color: rgba(239, 68, 68, 0.15) !important; color: #ef4444 !important; border-color: rgba(239, 68, 68, 0.3) !important;}

</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 dark:text-white flex items-center">
            <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26c.45.3.93.3 1.35 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            {{ __('Contact Support') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-8rem)]">
        <div class="max-w-3xl mx-auto">

            {{-- Form Liên hệ --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 sm:p-10 border border-gray-200 dark:border-gray-700">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 dark:bg-indigo-900/30 mb-6 border border-indigo-100 dark:border-indigo-800/50">
                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('How can we help you?') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        {{ __("Send us a message and we'll get back to you as soon as possible.") }}
                    </p>
                </div>

                {{-- Thông báo Flash Message (Success/Error) --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-xl relative mb-6 font-medium shadow-sm flex items-start"
                        role="alert">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="block sm:inline mt-0.5">{{ session('success') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl relative mb-6 font-medium shadow-sm flex items-start" role="alert">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span class="block sm:inline mt-0.5">Vui lòng kiểm tra lại các trường thông tin.</span>
                    </div>
                @endif

                <form action="{{ route('support.contact.submit') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Tên --}}
                        <div>
                            <label for="name"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Full Name') }}</label>
                            <input type="text" name="name" id="name" required
                                value="{{ old('name', auth()->user()->name ?? '') }}"
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 transition-colors">
                            @error('name') <p class="text-sm font-medium text-red-500 mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Email Address') }}</label>
                            <input type="email" name="email" id="email" required
                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 transition-colors">
                            @error('email') <p class="text-sm font-medium text-red-500 mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Chủ đề --}}
                    <div>
                        <label for="subject"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Subject') }}</label>
                        <input type="text" name="subject" id="subject" required value="{{ old('subject') }}"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 transition-colors">
                        @error('subject') <p class="text-sm font-medium text-red-500 mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nội dung --}}
                    <div>
                        <label for="message"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Message') }}</label>
                        <textarea name="message" id="message" rows="6" required
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 transition-colors resize-y">{{ old('message') }}</textarea>
                        @error('message') <p class="text-sm font-medium text-red-500 mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nút Gửi --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            {{ __('Send Message') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Thông báo hoặc liên hệ phụ --}}
            <div class="mt-10 max-w-2xl mx-auto">
                <div class="flex items-center justify-center mb-6">
                    <div class="h-px bg-gray-200 dark:bg-gray-700 flex-1"></div>
                    <span class="px-4 text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Or reach us directly via') }}</span>
                    <div class="h-px bg-gray-200 dark:bg-gray-700 flex-1"></div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="mailto:support@yourdomain.com"
                        class="flex flex-col items-center p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all group">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26c.45.3.93.3 1.35 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('Email Support') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">support@yourdomain.com</span>
                    </a>
                    
                    <a href="tel:+84123456789"
                        class="flex flex-col items-center p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all group">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.128a11.042 11.042 0 005.518 5.518l1.128-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-11a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('Phone Support') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">(0844) 420 444</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>