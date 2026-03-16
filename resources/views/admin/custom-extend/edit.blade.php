<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.custom-extend.index') }}"
               class="group p-3 rounded-2xl bg-white dark:bg-gray-800 text-gray-500 hover:text-blue-600 shadow-sm border border-gray-100 dark:border-gray-700 transition-all duration-200">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight leading-none">
                    {{ __('Edit Package') }}
                </h2>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-2">
                    {{ $package->name }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-[#161b22] rounded-[2.5rem] shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-[#30363d] overflow-hidden">

                {{-- Form Header --}}
                <div class="px-10 py-8 border-b border-gray-50 dark:border-[#30363d] bg-gray-50/50 dark:bg-[#1c2128]">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-600 rounded-2xl shadow-lg shadow-blue-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-widest text-sm">{{ __('Package Configuration') }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-1">Update pricing and availability settings</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.custom-extend.update', $package) }}" class="p-10 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Package Name --}}
                        <div class="space-y-2">
                            <label class="nk-section-label">{{ __('Package Name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $package->name) }}"
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