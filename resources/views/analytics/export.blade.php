@push('styles')
<style>
/* ── ANALYTICS EXPORT — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Interior elements */
.bg-gray-50.dark\:bg-gray-700,
.bg-gray-100.dark\:bg-gray-700 {
    background: var(--bg-layer) !important;
    border-color: var(--border) !important;
}

/* Inputs / Selects */
select.bg-gray-50.dark\:bg-gray-700,
input.bg-gray-50.dark\:bg-gray-700 {
    background: var(--bg-inner) !important;
    border: 1px solid var(--border) !important;
    color: var(--text-color) !important;
}

select:focus, input:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 1px #2563eb !important;
}

/* Actions */
.bg-gradient-to-r.from-indigo-600.to-purple-600 { background: #2563eb !important; }
.hover\:from-indigo-700.hover\:to-purple-700:hover { background: #1d4ed8 !important; }

/* Status Accents */
.text-indigo-600.dark\:text-indigo-400,
.text-indigo-600 { color: #2563eb !important; }
.bg-indigo-50.dark\:bg-indigo-900\/30 { background: rgba(37, 99, 235, 0.1) !important; color: #2563eb !important; }

.text-blue-600.dark\:text-blue-400 { color: #3b82f6 !important; }
.text-green-600, .text-green-500 { color: #10b981 !important; }
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('analytics.index') }}"
                    class="p-2.5 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Export & Reports') }}</h2>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-wider">{{ __('Download your analytics data in various formats') }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 py-8">

        {{-- Export Options --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Excel Export --}}
            <form action="{{ route('analytics.export.excel') }}" method="POST" id="form-excel" class="hidden">@csrf
            </form>
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl shadow-lg p-6 sm:p-8 text-white cursor-pointer hover:-translate-y-1 hover:shadow-xl transition-all relative overflow-hidden group"
                onclick="document.getElementById('form-excel').submit()">
                <div class="absolute -right-6 -top-6 p-8 bg-white/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:scale-110 duration-500 pointer-events-none">
                    <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="p-3.5 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black tracking-tight mb-2">{{ __('Excel (.xlsx)') }}</h3>
                    <p class="text-sm font-medium opacity-90 mb-6">{{ __('Complete data for last 30 days') }}</p>
                    <button
                        class="w-full px-5 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl font-bold transition-all shadow-sm">
                        {{ __('Download Excel') }}
                    </button>
                </div>
            </div>

            {{-- PDF Export --}}
            <form action="{{ route('analytics.export.pdf') }}" method="POST" id="form-pdf" class="hidden">@csrf</form>
            <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-3xl shadow-lg p-6 sm:p-8 text-white cursor-pointer hover:-translate-y-1 hover:shadow-xl transition-all relative overflow-hidden group"
                onclick="document.getElementById('form-pdf').submit()">
                <div class="absolute -right-6 -top-6 p-8 bg-white/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:scale-110 duration-500 pointer-events-none">
                    <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="p-3.5 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black tracking-tight mb-2">{{ __('PDF Report') }}</h3>
                    <p class="text-sm font-medium opacity-90 mb-6">{{ __('Professional formatted report (30d)') }}</p>
                    <button
                        class="w-full px-5 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl font-bold transition-all shadow-sm">
                        {{ __('Download PDF') }}
                    </button>
                </div>
            </div>

            {{-- CSV Export --}}
            <form action="{{ route('analytics.export.csv') }}" method="POST" id="form-csv" class="hidden">@csrf</form>
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl shadow-lg p-6 sm:p-8 text-white cursor-pointer hover:-translate-y-1 hover:shadow-xl transition-all relative overflow-hidden group"
                onclick="document.getElementById('form-csv').submit()">
                <div class="absolute -right-6 -top-6 p-8 bg-white/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:scale-110 duration-500 pointer-events-none">
                    <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="p-3.5 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black tracking-tight mb-2">{{ __('CSV Data') }}</h3>
                    <p class="text-sm font-medium opacity-90 mb-6">{{ __('Raw data for analysis tools (30d)') }}</p>
                    <button
                        class="w-full px-5 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl font-bold transition-all shadow-sm">
                        {{ __('Download CSV') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Custom Report Builder --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 sm:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 dark:bg-indigo-900/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none z-0"></div>
            
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center relative z-10">
                <span class="p-2.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl mr-4 border border-indigo-100 dark:border-indigo-800/50">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </span>
                {{ __('Custom Report Builder') }}
            </h3>

            <form id="reportForm" method="POST" action="{{ route('analytics.export.excel') }}" class="space-y-8 relative z-10">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Date Range --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">{{ __('Date Range') }}</label>
                        <select name="date_range"
                            class="w-full px-5 py-3.5 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 font-medium transition-all shadow-sm">
                            <option>Last 7 days</option>
                            <option selected>Last 30 days</option>
                            <option>Last 3 months</option>
                            <option>Last 6 months</option>
                            <option>Last year</option>
                        </select>
                    </div>

                    {{-- Format --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">{{ __('Format') }}</label>
                        <select id="formatSelect" name="format"
                            class="w-full px-5 py-3.5 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/20 font-medium transition-all shadow-sm"
                            onchange="updateFormAction(this.value)">
                            <option value="excel">Excel (.xlsx)</option>
                            <option value="pdf">PDF Report</option>
                            <option value="csv">CSV Data</option>
                        </select>
                    </div>
                </div>

                {{-- Include Options --}}
                <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4 uppercase tracking-wide">{{ __('Include in Report') }}</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <label
                            class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:border-indigo-300 dark:hover:border-indigo-600 transition-colors">
                            <input type="checkbox" name="include[]" value="transactions"
                                class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500/50 shadow-sm" checked>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Transactions') }}</span>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                    <button type="button" onclick="showPreview()"
                        class="w-full sm:w-auto px-8 py-3.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 shadow-sm">
                        {{ __('Preview Data') }}
                    </button>
                    <button type="submit"
                        class="w-full sm:w-auto px-8 py-3.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 focus:ring-4 focus:ring-indigo-500/30">
                        {{ __('Generate Report') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Recent Exports --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 sm:p-10">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center border-b border-gray-100 dark:border-gray-700 pb-4">
                <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
                {{ __('Recent Exports') }}
            </h3>

            <div class="overflow-hidden">
                <div class="space-y-4">
                    @forelse($exports as $export)
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-gray-50 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-600/50 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:border-indigo-100 dark:hover:border-indigo-800/50 transition-all gap-4">
                            <div class="flex items-center space-x-5">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shrink-0 shadow-md">
                                    @if($export->format == 'excel')
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @elseif($export->format == 'pdf')
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    @else
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-base font-bold text-gray-900 dark:text-white truncate">
                                        {{ ucfirst($export->type ?? 'Sales') }} Report -
                                        {{ $export->created_at->format('M Y') }}
                                    </p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="text-xs font-bold px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded uppercase tracking-wider">
                                            {{ ucfirst($export->format) }}
                                        </span>
                                        <span class="text-xs font-bold text-gray-400">
                                            •&nbsp; {{ $export->created_at->format('d M, Y H:i') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-400 font-medium mt-1">
                                        {{ $export->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 pl-19 sm:pl-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-200 dark:border-gray-700 w-full sm:w-auto justify-end">
                                @if($export->file_path)
                                    <a href="{{ route('analytics.export.download', $export->id) }}"
                                        class="flex items-center text-sm text-indigo-600 hover:text-white dark:text-indigo-400 font-bold px-4 py-2 rounded-xl border border-indigo-200 dark:border-indigo-800/50 bg-white dark:bg-gray-800 hover:bg-indigo-600 dark:hover:bg-indigo-600 hover:border-indigo-600 transition-all shadow-sm group">
                                        <svg class="w-4 h-4 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        {{ __('Download') }}
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400 italic font-medium px-4 py-2">{{ __('Expired') }}</span>
                                @endif

                                <form action="{{ route('analytics.export.destroy', $export->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this export log?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl transition-all border border-transparent hover:border-red-200 dark:hover:border-red-800/50" title="Delete record">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 dark:bg-gray-700/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-600">
                            <div
                                class="mx-auto w-20 h-20 bg-white dark:bg-gray-800 shadow-sm rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ __('No recent exports found') }}</h3>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 max-w-sm mx-auto">{{ __('Generate a new report using the custom report builder above to see it listed here.') }}</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $exports->links() }}
                </div>
            </div>
        </div>

    </div>

    {{-- Preview Modal --}}
    @include('analytics.partials.preview-modal')

    @push('scripts')
        <script>
            function updateFormAction(format) {
                const form = document.getElementById('reportForm');
                if (format === 'excel') {
                    form.action = "{{ route('analytics.export.excel') }}";
                } else if (format === 'pdf') {
                    form.action = "{{ route('analytics.export.pdf') }}";
                } else if (format === 'csv') {
                    form.action = "{{ route('analytics.export.csv') }}";
                }
            }

            function showPreview() {
                const form = document.getElementById('reportForm');
                const originalAction = form.action;

                // Collect form data
                const formData = new FormData(form);

                // Fetch preview data
                fetch("{{ route('analytics.export.preview') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        // Populate modal
                        const tbody = document.getElementById('previewTableBody');
                        tbody.innerHTML = '';

                        data.data.forEach(row => {
                            tbody.innerHTML += `
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 text-left font-medium">${row.date}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 text-left">#${row.order_code}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white text-left">${row.product}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-green-600 custom-font text-left">${row.amount}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold uppercase tracking-wider rounded-md bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                            ${row.status}
                                        </span>
                                    </td>
                                </tr>
                            `;
                        });

                        document.getElementById('previewTotalRecords').innerText = data.total_records;
                        document.getElementById('previewTotalAmount').innerText = data.total_amount;

                        // Show modal
                        document.getElementById('previewModal').classList.remove('hidden');
                    })
                    .catch(error => console.error('Error:', error));
            }

            function closePreview() {
                document.getElementById('previewModal').classList.add('hidden');
            }

            function submitExportFromPreview() {
                document.getElementById('reportForm').submit();
                closePreview();
            }
        </script>
    @endpush
</x-app-layout>