<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.custom-extend.index') }}"
                class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 transition">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
                {{ __('Edit Package') }}: {{ $package->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 min-h-screen bg-gray-50 dark:bg-gray-900 font-sans">
        <div class="max-w-3xl mx-auto">
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-8 py-6">
                    <h3 class="text-white text-xl font-bold">{{ __('Update Package Settings') }}</h3>
                    <p class="text-indigo-100 text-sm italic">{{ __('Changes will apply immediately to all users.') }}
                    </p>
                </div>

                <form action="{{ route('admin.custom-extend.update', $package->id) }}" method="POST"
                    class="p-8 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                            <label
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 text-indigo-600">{{ __('Display Name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $package->name) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition shadow-sm font-semibold">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 text-indigo-600">{{ __('Extension Days') }}</label>
                            <div class="relative">
                                <input type="number" name="days" value="{{ old('days', $package->days) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition shadow-sm font-bold">
                                <span class="absolute right-4 top-3 text-gray-400 text-sm">{{ __('days') }}</span>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800">
                            <span
                                class="text-sm font-bold text-indigo-700 dark:text-indigo-400 uppercase">{{ __('Status') }}</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" class="sr-only peer" {{ $package->is_active ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all">
                                </div>
                            </label>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 text-yellow-600">{{ __('Coin Payment Price') }}</label>
                            <input type="number" name="price_coinkey"
                                value="{{ old('price_coinkey', $package->price_coinkey) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 transition shadow-sm font-bold">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 text-green-600">{{ __('VND Payment Price') }}</label>
                            <input type="number" name="price_vnd" value="{{ old('price_vnd', $package->price_vnd) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 transition shadow-sm font-bold">
                            <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-tighter">*
                                {{ __('Minimum 2,000 VND (PayOS)') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:-translate-y-1 transition active:scale-95">
                            {{ __('SAVE CHANGES') }}
                        </button>
                        <a href="{{ route('admin.custom-extend.index') }}"
                            class="px-8 py-4 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition text-center uppercase text-sm tracking-widest">
                            {{ __('CANCEL') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>