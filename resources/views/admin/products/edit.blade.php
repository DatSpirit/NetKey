<x-app-layout>
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[100] space-y-3"></div>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">
                    {{ __('Edit Product') }}
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
                        ✏️ {{ __('Update Information') }}
                    </h3>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-wider mt-1">{{ __('Editing') }}: {{ $product->name }}</p>
                </div>

                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Active Checkbox -->
                    <div class="flex items-center space-x-3 bg-blue-50/50 dark:bg-blue-900/10 p-4 rounded-xl border border-blue-100/50 dark:border-blue-900/30">
                        <div class="flex items-center h-5">
                            <input id="is_active" name="is_active" type="checkbox" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded-lg focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700">
                        </div>
                        <label for="is_active"
                            class="text-sm font-bold text-gray-700 dark:text-gray-300 select-none cursor-pointer">
                            {{ __('Active (enabled)') }}
                        </label>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="nk-section-label">
                            {{ __('Product Name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-bold">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="nk-section-label">
                            {{ __('Category') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="category" name="category" required
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 cursor-pointer transition duration-200 font-bold">
                            <option value="Service"
                                {{ old('category', $product->category) == 'Service' ? 'selected' : '' }}>Service
                            </option>
                            <option value="Top-up"
                                {{ old('category', $product->category) == 'Top-up' ? 'selected' : '' }}>Top-up</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="nk-section-label">
                            {{ __('Cash Price') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" id="price" name="price"
                                value="{{ old('price', $product->price) }}" required min="0" step="1000"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-bold">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-black">₫</span>
                        </div>
                    </div>

                    <!-- TYPE CONFIGURATION -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 dark:bg-gray-800/30 p-5 rounded-2xl border border-gray-100 dark:border-gray-800">
                        <div class="md:col-span-2">
                            <label for="product_type" class="nk-section-label !text-blue-600 dark:!text-blue-400">
                                {{ __('Product Type') }}
                            </label>
                            <select id="product_type" name="product_type" onchange="toggleFields()"
                                class="w-full px-4 py-3 border-2 border-blue-100 dark:border-blue-900/30 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 cursor-pointer transition duration-200 font-bold">
                                <option value="package"
                                    {{ old('product_type', $product->product_type) == 'package' ? 'selected' : '' }}>📦
                                    {{ __('License Package') }}</option>
                                <option value="coinkey"
                                    {{ old('product_type', $product->product_type) == 'coinkey' ? 'selected' : '' }}>💰
                                    {{ __('Top-up Package') }}</option>
                            </select>
                            <p class="text-[10px] text-blue-500/70 dark:text-blue-400/50 mt-2 uppercase font-black tracking-wider" id="type_hint"></p>
                        </div>

                        <div>
                            <label id="coinkey_label" for="coinkey_amount" class="nk-section-label">
                                {{ __('Coin Price') }}
                            </label>
                            <div class="relative">
                                <input type="number" id="coinkey_amount" name="coinkey_amount"
                                    value="{{ old('coinkey_amount', $product->coinkey_amount) }}" required
                                    min="0"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-bold">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-lg">🪙</span>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-wider" id="coinkey_hint"></p>
                        </div>

                        <div id="duration_field">
                            <label for="duration_minutes" class="nk-section-label">
                                {{ __('Duration (Minutes)') }}
                            </label>
                            <input type="number" id="duration_minutes" name="duration_minutes"
                                value="{{ old('duration_minutes', $product->duration_minutes) }}"
                                class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-bold">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="nk-section-label">
                            {{ __('Description') }}
                        </label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-medium resize-none">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Product Image -->
                    <div>
                        <label class="nk-section-label">
                            {{ __('Product Image') }} <span class="text-gray-400 font-normal text-xs">({{ __('Optional, JPG/PNG/WebP, max 2MB') }})</span>
                        </label>

                        @if($product->image_url)
                        <!-- Current image -->
                        <div id="current-image-wrapper" class="mt-2 mb-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Current Image') }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ __('Upload a new image below to replace this one.') }}</p>
                                <label class="mt-2 flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="remove_image" value="1" id="remove_image_cb"
                                        class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-400"
                                        onchange="toggleRemoveImage(this)">
                                    <span class="text-xs text-red-500 font-semibold group-hover:text-red-700">🗑 {{ __('Remove current image') }}</span>
                                </label>
                            </div>
                        </div>
                        @endif

                        <div id="image-upload-area"
                            class="mt-2 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 transition-colors duration-200 relative"
                            onclick="document.getElementById('image_input').click()">
                            <!-- Preview -->
                            <div id="image-preview-wrapper" class="hidden mb-4">
                                <img id="image-preview" src="" alt="Preview"
                                    class="mx-auto max-h-40 rounded-xl object-contain shadow">
                            </div>
                            <!-- Placeholder -->
                            <div id="image-placeholder">
                                <svg class="mx-auto w-10 h-10 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">{{ __('Click to select a new image') }}</p>
                                <p class="text-xs text-gray-300 dark:text-gray-600 mt-1">JPG, PNG, WebP, GIF &mdash; max 2MB</p>
                            </div>
                            <input type="file" id="image_input" name="image" accept="image/*" class="hidden"
                                onchange="previewImage(this)">
                        </div>
                        @error('image')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <button type="button" id="clear-image-btn" class="hidden mt-2 text-xs text-red-500 hover:text-red-700 font-semibold"
                            onclick="clearImage()">✕ {{ __('Remove selected image') }}</button>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100 dark:border-gray-800">
                        <button type="submit"
                            class="flex-1 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-500/20 transform hover:-translate-y-0.5 transition-all duration-200 uppercase tracking-wider text-xs flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Update') }}
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

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview-wrapper').classList.remove('hidden');
                    document.getElementById('image-placeholder').classList.add('hidden');
                    document.getElementById('clear-image-btn').classList.remove('hidden');
                    // Uncheck remove_image if a new image is selected
                    const removeCb = document.getElementById('remove_image_cb');
                    if (removeCb) removeCb.checked = false;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearImage() {
            document.getElementById('image_input').value = '';
            document.getElementById('image-preview-wrapper').classList.add('hidden');
            document.getElementById('image-placeholder').classList.remove('hidden');
            document.getElementById('clear-image-btn').classList.add('hidden');
        }

        function toggleRemoveImage(checkbox) {
            const uploadArea = document.getElementById('image-upload-area');
            if (checkbox.checked) {
                uploadArea.style.opacity = '0.4';
                uploadArea.style.pointerEvents = 'none';
                clearImage();
            } else {
                uploadArea.style.opacity = '1';
                uploadArea.style.pointerEvents = 'auto';
            }
        }
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
