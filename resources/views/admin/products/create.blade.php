<x-app-layout>
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[100] space-y-3"></div>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">
                    {{ __('Add Product') }}
                </h2>
            </div>
            <a href="{{ route('products') }}"
                class="px-4 py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-bold rounded-xl hover:bg-gray-200 transition-all duration-200 text-xs uppercase tracking-wider">
                ← {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white dark:bg-[#161b22] shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-[#30363d]">
                <div class="bg-[#0a0f1e] p-6 border-b border-white/5">
                    <h3 class="text-xl font-black text-white flex items-center gap-2">
                        📦 {{ __('Product Information') }}
                    </h3>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-wider mt-1">{{ __('Fill in complete product information') }}</p>
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    <!-- Active Checkbox -->
                    <div class="flex items-center space-x-3 bg-blue-50/50 dark:bg-blue-900/10 p-4 rounded-xl border border-blue-100/50 dark:border-blue-900/30">
                        <div class="flex items-center h-5">
                            <input id="is_active" name="is_active" type="checkbox" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded-lg focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700">
                        </div>
                        <label for="is_active"
                            class="text-sm font-bold text-gray-700 dark:text-gray-300 select-none cursor-pointer">
                            {{ __('Activate product (Display on store immediately)') }}
                        </label>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="nk-section-label">
                            {{ __('Product Name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-bold">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="nk-section-label">
                            {{ __('Category') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="category" name="category" required
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 cursor-pointer transition duration-200 font-bold">
                            <option value="Service" {{ old('category') == 'Service' ? 'selected' : '' }}>{{ __('Service (License Package)') }}</option>
                            <option value="Top-up" {{ old('category') == 'Top-up' ? 'selected' : '' }}>{{ __('Top-up (Recharge)') }}
                            </option>
                        </select>
                    </div>

                    <!-- Price (VND) -->
                    <div>
                        <label for="price" class="nk-section-label">
                            {{ __('Cash Price') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" id="price" name="price" value="{{ old('price') }}" required
                                min="2000" step="1000"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-bold"
                                placeholder="{{ __('e.g: 50000') }}">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-black">₫</span>
                        </div>
                    </div>

                    <!-- TYPE CONFIGURATION -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 dark:bg-gray-800/30 p-5 rounded-2xl border border-gray-100 dark:border-gray-800">
                        <!-- Product Type -->
                        <div class="md:col-span-2">
                            <label for="product_type" class="nk-section-label !text-blue-600 dark:!text-blue-400">
                                {{ __('Product Type') }} <span class="text-red-500">*</span>
                            </label>
                            <select id="product_type" name="product_type" onchange="toggleFields()"
                                class="w-full px-4 py-3 border-2 border-blue-100 dark:border-blue-900/30 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 cursor-pointer transition duration-200 font-bold">
                                <option value="package" {{ old('product_type') == 'package' ? 'selected' : '' }}>📦 {{ __('License Package (Sell Key)') }}</option>
                                <option value="coinkey" {{ old('product_type') == 'coinkey' ? 'selected' : '' }}>💰 {{ __('Top-up Package') }}</option>
                            </select>
                            <p class="text-[10px] text-blue-500/70 dark:text-blue-400/50 mt-2 uppercase font-black tracking-wider" id="type_hint"></p>
                        </div>

                        <!-- Coinkey Amount -->
                        <div>
                            <label id="coinkey_label" for="coinkey_amount" class="nk-section-label">
                                {{ __('Coin Price') }}
                            </label>
                            <div class="relative">
                                <input type="number" id="coinkey_amount" name="coinkey_amount"
                                    value="{{ old('coinkey_amount', 0) }}" required min="0"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-bold">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-lg">🪙</span>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-wider" id="coinkey_hint"></p>
                        </div>

                        <!-- Duration -->
                        <div id="duration_field">
                            <label for="duration_minutes" class="nk-section-label">
                                {{ __('Duration (Minutes)') }}
                            </label>
                            <input type="number" id="duration_minutes" name="duration_minutes"
                                value="{{ old('duration_minutes', 1440) }}"
                                class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-bold">
                            <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-wider">{{ __('1440 minutes = 1 day') }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="nk-section-label">
                            {{ __('Description') }}
                        </label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-medium resize-none">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100 dark:border-gray-800">
                        <button type="submit"
                            class="flex-1 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-500/20 transform hover:-translate-y-0.5 transition-all duration-200 uppercase tracking-wider text-xs flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Save Product') }}
                        </button>
                        <a href="{{ route('products') }}"
                            class="flex-1 px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-bold rounded-xl hover:bg-gray-200 transition-all duration-200 text-xs uppercase tracking-wider text-center">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const translations = {
            coinkeyReceived: @json(__('Coinkey amount RECEIVED')),
            cashToCoins: @json(__('Customer pays cash -> Receives Coins.')),
            topupMode: @json(__('Mode: Top-up Package.')),
            coinPrice: @json(__('Coinkey selling price')),
            coinToBuy: @json(__('Customer uses Coins to buy.')),
            licenseMode: @json(__('Mode: License Package (Service).'))
        };

        function toggleFields() {
            const type = document.getElementById('product_type').value;
            const durationField = document.getElementById('duration_field');
            const coinkeyLabel = document.getElementById('coinkey_label');
            const coinkeyHint = document.getElementById('coinkey_hint');
            const typeHint = document.getElementById('type_hint');

            if (type === 'coinkey') {
                durationField.style.display = 'none';
                coinkeyLabel.innerText = translations.coinkeyReceived;
                coinkeyHint.innerText = translations.cashToCoins;
                typeHint.innerText = translations.topupMode;
            } else {
                durationField.style.display = 'block';
                coinkeyLabel.innerText = translations.coinPrice;
                coinkeyHint.innerText = translations.coinToBuy;
                typeHint.innerText = translations.licenseMode;
            }
        }
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
    <script>
        // Show flash messages
        @if (session('success'))
            setTimeout(() => {
                alert('✅ {{ session('success') }}');
            }, 100);
        @endif
        @if (session('error'))
            setTimeout(() => {
                alert('❌ {{ session('error') }}');
            }, 100);
        @endif
    </script>
</x-app-layout>
