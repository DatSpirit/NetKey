<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white">
                    {{ __('Edit Key') }}
                </h2>
                @if($key->trashed())
                    <span
                        class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-300 text-sm rounded-lg font-bold">
                        {{ __('DELETED') }}
                    </span>
                @endif
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.keys.show', $key->id) }}"
                    class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 transition">
                    {{ __('View Info') }}
                </a>
                <a href="{{ route('admin.keys.index') }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 transition">
                    ← {{ __('Go Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-r-xl">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-r-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold text-red-800 dark:text-red-200 mb-2">{{ __('An error occurred') }}:</p>
                        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Form --}}
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('admin.keys.update', $key->id) }}"
                    class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    @csrf
                    @method('PUT')

                    <h3 class="text-xl font-semibold mb-6 text-gray-800 dark:text-white flex items-center gap-2">
                        {{ __('Edit Information') }}
                    </h3>

                    <div class="space-y-6">

                        {{-- Key Code --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Key Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="key_code" value="{{ old('key_code', $key->key_code) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition font-mono"
                                required>
                            <p class="text-xs text-gray-500 mt-1">{{ __('Only letters, numbers and dashes allowed') }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Status') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                                <option value="active" {{ old('status', $key->status) == 'active' ? 'selected' : '' }}>
                                    {{ __('Active') }}
                                </option>
                                <option value="expired" {{ old('status', $key->status) == 'expired' ? 'selected' : '' }}>
                                    {{ __('Expired') }}
                                </option>
                                <option value="suspended" {{ old('status', $key->status) == 'suspended' ? 'selected' : '' }}> {{ __('Suspended') }}</option>
                                <option value="revoked" {{ old('status', $key->status) == 'revoked' ? 'selected' : '' }}>
                                    {{ __('Revoked') }}
                                </option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Duration --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Duration (minutes)') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="duration_minutes"
                                    value="{{ old('duration_minutes', $key->duration_minutes) }}" min="0"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition"
                                    required>
                            </div>

                            {{-- Expires At --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Expiration Date') }}
                                </label>
                                <input type="datetime-local" name="expires_at"
                                    value="{{ old('expires_at', $key->expires_at ? $key->expires_at->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                                <p class="text-xs text-gray-500 mt-1">{{ __('Leave blank = unlimited') }}</p>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Notes') }}
                            </label>
                            <textarea name="notes" rows="4"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition"
                                placeholder="{{ __('Add notes about this key...') }}">{{ old('notes', $key->notes) }}</textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Save Changes') }}
                            </button>
                            <a href="{{ route('admin.keys.index') }}"
                                class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 font-semibold transition">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Actions Sidebar --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Quick Info --}}
                <div
                    class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">📋 {{ __('Quick Info') }}</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">ID:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">#{{ $key->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Owner') }}:</span>
                            <span
                                class="font-semibold text-gray-900 dark:text-white">{{ $key->user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Type') }}:</span>
                            <span
                                class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($key->key_type) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Validation') }}:</span>
                            <span
                                class="font-semibold text-gray-900 dark:text-white">{{ number_format($key->validation_count) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Created at') }}:</span>
                            <span
                                class="text-xs text-gray-900 dark:text-white">{{ $key->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div
                    class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">⚡ {{ __('Quick Actions') }}
                    </h3>

                    <div class="space-y-3">
                        @if(!$key->trashed())
                            @if($key->status == 'active')
                                <form action="{{ route('admin.keys.suspend', $key->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('{{ __('Suspend this key?') }}')"
                                        class="w-full px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-lg hover:bg-yellow-200 font-medium transition text-sm">
                                        🔒 {{ __('Suspend') }}
                                    </button>
                                </form>
                            @elseif($key->status == 'suspended')
                                <form action="{{ route('admin.keys.activate', $key->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 font-medium transition text-sm">
                                        ✅ {{ __('Activate') }}
                                    </button>
                                </form>
                            @endif

                            <button onclick="openExtendModal()"
                                class="w-full px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 font-medium transition text-sm">
                                ⏱️ {{ __('Extend') }}
                            </button>

                            <form action="{{ route('admin.keys.revoke', $key->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('{{ __('Permanently revoke this key?') }}')"
                                    class="w-full px-4 py-2 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 rounded-lg hover:bg-orange-200 font-medium transition text-sm">
                                    🚫 {{ __('Revoke') }}
                                </button>
                            </form>

                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                <button onclick="openDeleteModal()"
                                    class="w-full px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 font-medium transition text-sm">
                                    🗑️ {{ __('Delete Key') }}
                                </button>
                            </div>
                        @else
                            <form action="{{ route('admin.keys.restore', $key->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 font-medium transition">
                                    ♻️ {{ __('Restore Key') }}
                                </button>
                            </form>

                            <form action="{{ route('admin.keys.force-delete', $key->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('PERMANENTLY DELETE? This action CANNOT be undone!') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                                    ⚠️ {{ __('Delete Forever') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Extend Modal --}}
    <div id="extendModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">⏱️ {{ __('Extend Key') }}</h3>

            <form method="POST" action="{{ route('admin.keys.extend-admin', $key->id) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label
                            class="block font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Extension minutes') }}</label>
                        <input type="number" name="additional_minutes" min="1" required
                            class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            placeholder="{{ __('e.g: 1440 (1 day)') }}">
                    </div>

                    <div>
                        <label
                            class="block font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Reason (optional)') }}</label>
                        <input type="text" name="reason"
                            class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            placeholder="{{ __('e.g: Customer request') }}">
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeExtendModal()"
                            class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-lg hover:bg-gray-300">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ __('Confirm Delete Key') }}
                </h3>
            </div>

            <div class="p-6">
                <div
                    class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <strong>⚠️ {{ __('Note') }}:</strong> {{ __('Key will be soft deleted. User will no longer see this key.') }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-700 dark:text-gray-300 mb-2">Key Code:</p>
                    <p class="font-mono font-bold text-lg text-red-600">{{ $key->key_code }}</p>
                </div>

                <form action="{{ route('admin.keys.destroy', $key->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 font-medium transition">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                           {{ __('Delete Key') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openExtendModal() {
            document.getElementById('extendModal').classList.remove('hidden');
        }

        function closeExtendModal() {
            document.getElementById('extendModal').classList.add('hidden');
        }

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function (event) {
            const extendModal = document.getElementById('extendModal');
            const deleteModal = document.getElementById('deleteModal');

            if (event.target === extendModal) {
                closeExtendModal();
            }
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>