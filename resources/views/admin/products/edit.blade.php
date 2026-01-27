<x-app-layout>
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[100] space-y-3"></div>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 tracking-tight">
                    {{ __('Edit Product') }}
                </h2>
            </div>
            <a href="{{ route('products') }}"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-all duration-200">
                ← {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-3xl mx-auto">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 dark:from-blue-600 dark:to-cyan-700 p-6">
                    <h3 class="text-xl font-bold text-white">{{ __('Update Information') }}</h3>
                    <p class="text-white/90 text-sm mt-1">{{ __('Editing') }}: {{ $product->name }}</p>
                </div>

                <form action="{{ route('admin.products.update', $product) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Active Checkbox -->
                    <div
                        class="flex items-center space-x-3 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-xl border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center h-5">
                            <input id="is_active" name="is_active" type="checkbox" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <label for="is_active"
                            class="font-medium text-gray-700 dark:text-gray-300 select-none cursor-pointer">
                            {{ __('Active (enabled)') }}
                        </label>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Product Name') }} <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                            required
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-100 focus:border-blue-500 transition-all">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Category') }} <span
                                class="text-red-500">*</span></label>
                        <select id="category" name="category" required
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-100 focus:border-blue-500 cursor-pointer">
                            <option value="Service"
                                {{ old('category', $product->category) == 'Service' ? 'selected' : '' }}>Service
                            </option>
                            <option value="Top-up"
                                {{ old('category', $product->category) == 'Top-up' ? 'selected' : '' }}>Top-up</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Cash Price') }} <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" id="price" name="price"
                                value="{{ old('price', $product->price) }}" required min="0" step="1000"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-100 focus:border-blue-500 pl-10">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">₫</span>
                        </div>
                    </div>

                    <!-- TYPE CONFIGURATION -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800">
                        <div class="md:col-span-2">
                            <label for="product_type"
                                class="block text-sm font-bold text-blue-800 dark:text-blue-300 mb-2">{{ __('Product Type') }}</label>
                            <select id="product_type" name="product_type" onchange="toggleFields()"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-blue-200 dark:border-blue-700 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-100 focus:ring-blue-500 cursor-pointer">
                                <option value="package"
                                    {{ old('product_type', $product->product_type) == 'package' ? 'selected' : '' }}>📦
                                    {{ __('License Package') }}</option>
                                <option value="coinkey"
                                    {{ old('product_type', $product->product_type) == 'coinkey' ? 'selected' : '' }}>💰
                                    {{ __('Top-up Package') }}</option>
                            </select>
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-2" id="type_hint"></p>
                        </div>

                        <div>
                            <label id="coinkey_label" for="coinkey_amount"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Coin Price') }}</label>
                            <div class="relative">
                                <input type="number" id="coinkey_amount" name="coinkey_amount"
                                    value="{{ old('coinkey_amount', $product->coinkey_amount) }}" required
                                    min="0"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-100 focus:border-blue-500 pl-10">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2">🪙</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1" id="coinkey_hint"></p>
                        </div>

                        <div id="duration_field">
                            <label for="duration_minutes"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Duration (Minutes)') }}</label>
                            <input type="number" id="duration_minutes" name="duration_minutes"
                                value="{{ old('duration_minutes', $product->duration_minutes) }}"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-100 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Description') }}</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-100 focus:border-blue-500 resize-none">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl shadow-lg transition-all">{{ __('Update') }}</button>
                        <a href="{{ route('products') }}"
                            class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white font-bold rounded-xl text-center transition-all">{{ __('Cancel') }}</a>
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
