<x-app-layout>
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
                    {{ __('Edit Key') }}
                </h2>
                @if($key->trashed())
                    <span
                        class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-300 text-[10px] font-black uppercase tracking-wider rounded-full border border-red-200 dark:border-red-800">
                        {{ __('DELETED') }}
                    </span>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.keys.show', $key->id) }}"
                    class="px-4 py-2.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-bold rounded-xl hover:bg-blue-100 transition-all duration-200 text-xs uppercase tracking-wider">
                    {{ __('View Info') }}
                </a>
                <a href="{{ route('admin.keys.index') }}"
                    class="px-4 py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-bold rounded-xl hover:bg-gray-200 transition-all duration-200 text-xs uppercase tracking-wider">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">            {{-- Main Form --}}
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('admin.keys.update', $key->id) }}"
                    class="bg-white dark:bg-[#161b22] shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-[#30363d]">
                    @csrf
                    @method('PUT')

                    <div class="bg-[#0a0f1e] p-6 border-b border-white/5">
                        <h3 class="text-xl font-black text-white flex items-center gap-2">
                            {{ __('Edit Information') }}
                        </h3>
                    </div>

                    <div class="p-6 sm:p-8 space-y-6">

                        {{-- Key Code --}}
                        <div>
                            <label class="nk-section-label">
                                Key Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="key_code" value="{{ old('key_code', $key->key_code) }}"
                                class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 font-mono font-bold"
                                required>
                            <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-wider">{{ __('Only letters, numbers and dashes allowed') }}
                            </p>
                        </div>

                        <div>
                            <label class="nk-section-label">
                                {{ __('Status') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 cursor-pointer transition duration-200">
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
                                <label class="nk-section-label">
                                    {{ __('Duration (minutes)') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="duration_minutes"
                                    value="{{ old('duration_minutes', $key->duration_minutes) }}" min="0"
                                    class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200"
                                    required>
                            </div>

                            {{-- Expires At --}}
                            <div>
                                <label class="nk-section-label">
                                    {{ __('Expiration Date') }}
                                </label>
                                <input type="datetime-local" name="expires_at"
                                    value="{{ old('expires_at', $key->expires_at ? $key->expires_at->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200 cursor-pointer">
                                <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-wider">{{ __('Leave blank = unlimited') }}</p>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="nk-section-label">
                                {{ __('Notes') }}
                            </label>
                            <textarea name="notes" rows="4"
                                class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200"
                                placeholder="{{ __('Add notes about this key...') }}">{{ old('notes', $key->notes) }}</textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-800">
                            <a href="{{ route('admin.keys.index') }}"
                                class="px-6 py-3 bg-white border-2 border-gray-100 dark:bg-gray-800 dark:border-gray-700 text-gray-700 dark:text-gray-200 font-bold rounded-xl shadow-sm hover:bg-gray-50 transition-all duration-200 uppercase tracking-wider text-xs">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 uppercase tracking-wider text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Actions Sidebar --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Quick Info --}}
                <div
                    class="bg-white dark:bg-[#161b22] shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-[#30363d]">
                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-wider flex items-center gap-2">
                            📋 {{ __('Quick Info') }}
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider text-[10px]">ID:</span>
                            <span class="font-black text-blue-600 dark:text-blue-400">#{{ $key->id }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider text-[10px]">{{ __('Owner') }}:</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $key->user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider text-[10px]">{{ __('Type') }}:</span>
                            <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-wider rounded border border-blue-100 dark:border-blue-900/50">
                                {{ ucfirst($key->key_type) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider text-[10px]">{{ __('Validation') }}:</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ number_format($key->validation_count) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider text-[10px]">{{ __('Created at') }}:</span>
                            <span class="text-[11px] font-bold text-gray-900 dark:text-white">{{ $key->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div
                    class="bg-white dark:bg-[#161b22] shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-[#30363d]">
                    <div class="bg-[#0a0f1e] px-6 py-4 border-b border-white/5">
                        <h3 class="text-sm font-black text-white uppercase tracking-wider flex items-center gap-2">
                            ⚡ {{ __('Quick Actions') }}
                        </h3>
                    </div>

                    <div class="p-6 space-y-3">
                        @if(!$key->trashed())
                            @if($key->status == 'active')
                                <form action="{{ route('admin.keys.suspend', $key->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('{{ __('Suspend this key?') }}')"
                                        class="w-full px-4 py-3 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-100 font-bold transition-all duration-200 text-xs uppercase tracking-wider border border-amber-100 dark:border-amber-900/30">
                                        🔒 {{ __('Suspend') }}
                                    </button>
                                </form>
                            @elseif($key->status == 'suspended')
                                <form action="{{ route('admin.keys.activate', $key->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-xl hover:bg-green-100 font-bold transition-all duration-200 text-xs uppercase tracking-wider border border-green-100 dark:border-green-900/30">
                                        ✅ {{ __('Activate') }}
                                    </button>
                                </form>
                            @endif

                            <button onclick="openExtendModal()"
                                class="w-full px-4 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-100 font-bold transition-all duration-200 text-xs uppercase tracking-wider border border-blue-100 dark:border-blue-900/30">
                                ⏱️ {{ __('Extend') }}
                            </button>

                            <form action="{{ route('admin.keys.revoke', $key->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('{{ __('Permanently revoke this key?') }}')"
                                    class="w-full px-4 py-3 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl hover:bg-red-100 font-bold transition-all duration-200 text-xs uppercase tracking-wider border border-red-100 dark:border-red-900/30">
                                    🚫 {{ __('Revoke') }}
                                </button>
                            </form>

                            <div class="pt-3 border-t border-gray-100 dark:border-gray-800">
                                <button onclick="openDeleteModal()"
                                    class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 rounded-xl hover:bg-gray-200 font-bold transition-all duration-200 text-xs uppercase tracking-wider">
                                    🗑️ {{ __('Delete Key') }}
                                </button>
                            </div>
                        @else
                            <form action="{{ route('admin.keys.restore', $key->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 font-bold transition-all duration-200 text-xs uppercase tracking-wider shadow-lg shadow-green-500/20">
                                    ♻️ {{ __('Restore Key') }}
                                </button>
                            </form>

                            <form action="{{ route('admin.keys.force-delete', $key->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('PERMANENTLY DELETE? This action CANNOT be undone!') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-bold transition-all duration-200 text-xs uppercase tracking-wider shadow-lg shadow-red-500/20 mt-3">
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
        <div class="bg-white dark:bg-[#161b22] rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden border border-gray-100 dark:border-[#30363d]">
            <div class="bg-[#0a0f1e] px-6 py-5 border-b border-white/5">
                <h3 class="text-xl font-black text-white flex items-center gap-2">⏱️ {{ __('Extend Key') }}</h3>
            </div>

            <form method="POST" action="{{ route('admin.keys.extend-admin', $key->id) }}">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="nk-section-label">{{ __('Extension minutes') }}</label>
                        <input type="number" name="additional_minutes" min="1" required
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200"
                            placeholder="{{ __('e.g: 1440 (1 day)') }}">
                    </div>

                    <div>
                        <label class="nk-section-label">{{ __('Reason (optional)') }}</label>
                        <input type="text" name="reason"
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200"
                            placeholder="{{ __('e.g: Customer request') }}">
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeExtendModal()"
                            class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-bold rounded-xl hover:bg-gray-200 transition-all duration-200 text-xs uppercase tracking-wider">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all duration-200 text-xs uppercase tracking-wider">
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-[#161b22] rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden border border-gray-100 dark:border-[#30363d]">
            <div class="bg-[#0a0f1e] px-6 py-5 border-b border-white/5">
                <h3 class="text-xl font-black text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ __('Confirm Delete Key') }}
                </h3>
            </div>

            <div class="p-6">
                <div
                    class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                    <p class="text-xs font-bold text-amber-800 dark:text-amber-200 uppercase tracking-wider">
                        <strong>⚠️ {{ __('Note') }}:</strong> {{ __('Key will be soft deleted. User will no longer see this key.') }}
                    </p>
                </div>

                <div class="mb-6 text-center">
                    <p class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[2px] mb-2">Key Code:</p>
                    <p class="font-mono font-black text-2xl text-red-600 select-all">{{ $key->key_code }}</p>
                </div>

                <form action="{{ route('admin.keys.destroy', $key->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-bold rounded-xl hover:bg-gray-200 transition-all duration-200 text-xs uppercase tracking-wider">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg shadow-red-500/20 transition-all duration-200 text-xs uppercase tracking-wider">
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