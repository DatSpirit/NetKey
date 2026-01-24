<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('analytics.index') }}"
                    class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Export & Reports</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Download your analytics data in various
                        formats</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Export Options --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Excel Export --}}
            <form action="{{ route('analytics.export.excel') }}" method="POST" id="form-excel" class="hidden">@csrf
            </form>
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white cursor-pointer hover:scale-105 transition-transform"
                onclick="document.getElementById('form-excel').submit()">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-2">Excel (.xlsx)</h3>
                <p class="text-sm opacity-90 mb-4">Complete data for last 30 days</p>
                <button
                    class="w-full px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg font-semibold transition-all">
                    Download Excel
                </button>
            </div>

            {{-- PDF Export --}}
            <form action="{{ route('analytics.export.pdf') }}" method="POST" id="form-pdf" class="hidden">@csrf</form>
            <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl shadow-xl p-6 text-white cursor-pointer hover:scale-105 transition-transform"
                onclick="document.getElementById('form-pdf').submit()">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-2">PDF Report</h3>
                <p class="text-sm opacity-90 mb-4">Professional formatted report for last 30 days</p>
                <button
                    class="w-full px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg font-semibold transition-all">
                    Download PDF
                </button>
            </div>

            {{-- CSV Export --}}
            <form action="{{ route('analytics.export.csv') }}" method="POST" id="form-csv" class="hidden">@csrf</form>
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl p-6 text-white cursor-pointer hover:scale-105 transition-transform"
                onclick="document.getElementById('form-csv').submit()">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-2">CSV Data</h3>
                <p class="text-sm opacity-90 mb-4">Raw data for analysis tools (last 30 days)</p>
                <button
                    class="w-full px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg font-semibold transition-all">
                    Download CSV
                </button>
            </div>
        </div>

        {{-- Custom Report Builder --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-7 h-7 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                Custom Report Builder
            </h3>

            <form id="reportForm" method="POST" action="{{ route('analytics.export.excel') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- Date Range --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date
                            Range</label>
                        <select name="date_range"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500">
                            <option>Last 7 days</option>
                            <option selected>Last 30 days</option>
                            <option>Last 3 months</option>
                            <option>Last 6 months</option>
                            <option>Last year</option>
                        </select>
                    </div>

                    {{-- Format --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Format</label>
                        <select id="formatSelect" name="format"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500"
                            onchange="updateFormAction(this.value)">
                            <option value="excel">Excel (.xlsx)</option>
                            <option value="pdf">PDF Report</option>
                            <option value="csv">CSV Data</option>
                        </select>
                    </div>
                </div>

                {{-- Include Options (Visual only as backend always includes all for now, or we can filter fields later)
                --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Include in
                        Report</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label
                            class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input type="checkbox" name="include[]" value="transactions"
                                class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500" checked>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Transactions</span>
                        </label>
                        {{-- Other options are visual for now as logic is "Analytics Export" --}}
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="showPreview()"
                        class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                        Preview
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg shadow-indigo-500/50">
                        Generate Report
                    </button>
                </div>
            </form>
        </div>

        {{-- Recent Exports --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Recent Exports
            </h3>

            <div class="overflow-hidden">
                <div class="space-y-3">
                    @forelse($exports as $export)
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors gap-4">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shrink-0">
                                    @if($export->format == 'excel')
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @elseif($export->format == 'pdf')
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ ucfirst($export->type ?? 'Sales') }} Report -
                                        {{ $export->created_at->format('M Y') }}
                                    </p>
                                    <p class="text-xs text-indigo-500 font-medium mt-0.5">
                                        {{ $export->created_at->format('d M, Y H:i') }}
                                        <span class="text-gray-400 mx-1">•</span>
                                        {{ $export->created_at->diffForHumans() }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ ucfirst($export->format) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 pl-16 sm:pl-0">
                                @if($export->file_path)
                                    <a href="{{ route('analytics.export.download', $export->id) }}"
                                        class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium px-3 py-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                        Download Again
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400 italic px-3 py-1.5">Expired</span>
                                @endif

                                <form action="{{ route('analytics.export.destroy', $export->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this export log?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-gray-400 hover:text-red-500 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div
                                class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No recent exports found.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 text-left">${row.date}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 text-left">${row.order_code}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 text-left">${row.product}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 custom-font text-left">${row.amount}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
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