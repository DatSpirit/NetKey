<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\ExportLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnalyticsExport;
use Illuminate\Support\Facades\Storage;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $days = $request->input('days', 30);
        $startDate = now()->subDays($days);
        $endDate = now();

        // Get filter parameters
        $filters = [
            'status' => $request->input('status'),
            'method' => $request->input('method'),
            'product_id' => $request->input('product_id'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId
        ];

        // Get Data
        $transactions = $this->getFilteredTransactions($filters);
        $analytics = $this->calculateAnalytics($transactions, $startDate, $endDate);

        // View Data
        $products = Product::orderBy('name')->get();

        // Pass everything to view
        return view('analytics.index', array_merge($analytics, [
            'products' => $products,
            'transactions' => $transactions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'days' => $days,
        ]));
    }

    public function export()
    {
        $exports = ExportLog::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('analytics.export', compact('exports'));
    }

    public function download($id)
    {
        $export = ExportLog::where('user_id', Auth::id())->findOrFail($id);

        if (!$export->file_path || !Storage::disk('local')->exists($export->file_path)) {
            return back()->with('error', 'File not found. It may have been deleted.');
        }

        return Storage::disk('local')->download($export->file_path, $export->file_name);
    }

    public function destroy($id)
    {
        $export = ExportLog::where('user_id', Auth::id())->findOrFail($id);

        if ($export->file_path && Storage::disk('local')->exists($export->file_path)) {
            Storage::disk('local')->delete($export->file_path);
        }

        $export->delete();

        return back()->with('success', 'Export deleted successfully.');
    }

    public function preview(Request $request)
    {
        $userId = Auth::id();
        $days = $this->getDaysFromRange($request->input('date_range', 'Last 30 days'));

        $filters = [
            'user_id' => $userId,
            'start_date' => now()->subDays($days),
            'end_date' => now(),
            'status' => 'success', // Default to success for reports usually, or allow filter
            'method' => null,
            'product_id' => null
        ];

        $transactions = $this->getFilteredTransactions($filters);

        // Return first 5 rows as preview
        $previewData = $transactions->take(5)->map(function ($t) {
            return [
                'date' => $t->created_at->format('Y-m-d'),
                'order_code' => $t->order_code,
                'product' => $t->product->name ?? 'N/A',
                'amount' => number_format($t->amount) . ' ' . $t->currency,
                'status' => $t->status
            ];
        });

        return response()->json([
            'data' => $previewData,
            'total_records' => $transactions->count(),
            'total_amount' => number_format($transactions->sum('amount'))
        ]);
    }

    public function exportExcel(Request $request)
    {
        $userId = Auth::id();
        $days = $this->getDaysFromRange($request->input('date_range', 'Last 30 days'));

        $filters = [
            'user_id' => $userId,
            'start_date' => now()->subDays($days),
            'end_date' => now(),
        ];

        $transactions = $this->getFilteredTransactions($filters);

        $filename = 'analytics-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        $path = 'exports/' . $userId . '/' . $filename;

        Excel::store(new AnalyticsExport($transactions), $path, 'local');

        $this->logExport($userId, 'excel', 'excel', $filename, $path);

        return Storage::disk('local')->download($path);
    }

    public function exportPdf(Request $request)
    {
        $userId = Auth::id();
        $days = $this->getDaysFromRange($request->input('date_range', 'Last 30 days'));

        $filters = [
            'user_id' => $userId,
            'start_date' => now()->subDays($days),
            'end_date' => now(),
        ];

        $transactions = $this->getFilteredTransactions($filters);

        $totalRevenue = $transactions->where('status', 'success')->sum('amount');
        $successCount = $transactions->where('status', 'success')->count();

        $pdf = Pdf::loadView('analytics.pdf-template', [
            'transactions' => $transactions,
            'totalRevenue' => $totalRevenue,
            'successCount' => $successCount,
            'start_date' => now()->subDays($days)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'user' => Auth::user()
        ]);

        $filename = 'analytics-report-' . now()->format('Y-m-d-H-i-s') . '.pdf';
        $path = 'exports/' . $userId . '/' . $filename;

        Storage::disk('local')->put($path, $pdf->output());

        $this->logExport($userId, 'pdf', 'pdf', $filename, $path);

        return Storage::disk('local')->download($path);
    }

    public function exportCsv(Request $request)
    {
        $userId = Auth::id();
        $days = $this->getDaysFromRange($request->input('date_range', 'Last 30 days'));

        $filters = [
            'user_id' => $userId,
            'start_date' => now()->subDays($days),
            'end_date' => now(),
        ];

        $transactions = $this->getFilteredTransactions($filters);

        $filename = 'analytics-' . now()->format('Y-m-d-H-i-s') . '.csv';
        $path = 'exports/' . $userId . '/' . $filename;

        // Generate CSV content
        $csvContent = "\xEF\xBB\xBF"; // BOM
        $csvContent .= implode(',', ['Date', 'Order Code', 'Product', 'Amount', 'Currency', 'Status']) . "\n";

        foreach ($transactions as $t) {
            $csvContent .= implode(',', [
                $t->created_at->format('Y-m-d H:i:s'),
                $t->order_code,
                $t->product->name ?? 'N/A',
                $t->amount,
                $t->currency,
                $t->status,
            ]) . "\n";
        }

        Storage::disk('local')->put($path, $csvContent);

        $this->logExport($userId, 'csv', 'csv', $filename, $path);

        return Storage::disk('local')->download($path);
    }

    // ============================
    // PRIVATE HELPERS
    // ============================

    private function getFilteredTransactions($filters)
    {
        $query = Transaction::where('transactions.user_id', $filters['user_id'])
            ->whereBetween('transactions.created_at', [$filters['start_date'], $filters['end_date']])
            ->with('product');

        if (!empty($filters['status'])) {
            $query->where('transactions.status', $filters['status']);
        }
        if (!empty($filters['method'])) {
            $query->where('transactions.currency', $filters['method']);
        }
        if (!empty($filters['product_id'])) {
            $query->where('transactions.product_id', $filters['product_id']);
        }

        return $query->orderBy('transactions.created_at', 'desc')->get();
    }

    private function calculateAnalytics($transactions, $startDate, $endDate)
    {
        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();

        // SPLIT REVENUE
        $totalVND = $transactions->where('status', 'success')->where('currency', 'VND')->sum('amount');
        $totalCoin = $transactions->where('status', 'success')->where('currency', 'COINKEY')->sum('amount');

        // KPI SECTION
        $analytics = [
            'totalRevenueVND' => $totalVND,
            'totalRevenueCoin' => $totalCoin,
            'ordersTotal' => $transactions->count(),
            'ordersSuccess' => $transactions->where('status', 'success')->count(),
            'successRate' => $this->successRate($transactions),
            'walletBalance' => $wallet->balance,
            'walletDeposited' => $wallet->total_deposited,
            'walletSpent' => $wallet->total_spent,
        ];

        // REVENUE TREND
        $trend = $transactions
            ->where('status', 'success')
            ->groupBy(fn($t) => $t->created_at->format('Y-m-d'))
            ->map(fn($rows, $date) => [
                'date' => $date,
                'total' => $rows->sum('amount')
            ])
            ->values();

        // PAYMENT DISTRIBUTION / CURRENCY STATS
        $currencyStats = [
            'COINKEY' => [
                'count' => $transactions->where('currency', 'COINKEY')->count(),
                'volume' => $transactions->where('status', 'success')->where('currency', 'COINKEY')->sum('amount')
            ],
            'VND' => [
                'count' => $transactions->where('currency', 'VND')->count(),
                'volume' => $transactions->where('status', 'success')->where('currency', 'VND')->sum('amount')
            ],
        ];

        // SPENDING HABITS (Day of Week Bar Chart)
        $spendingByDay = array_fill(0, 7, 0); // 0=Sunday, 6=Saturday
        foreach ($transactions->where('status', 'success') as $t) {
            $day = (int) $t->created_at->format('w');
            $spendingByDay[$day] += $t->amount;
        }

        // HOURLY HEATMAP
        $hourly = array_fill(0, 24, 0);
        foreach ($transactions->where('status', 'success') as $t) {
            $hour = (int) $t->created_at->format('H');
            $hourly[$hour]++;
        }

        // TOP PRODUCTS
        $topProducts = $transactions->where('status', 'success')
            ->groupBy('product_id')
            ->map(function ($group) {
                return (object) [
                    'product_name' => $group->first()->product->name ?? 'Unknown',
                    'orders' => $group->count(),
                    'total' => $group->sum('amount')
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values();

        $topCustomers = $transactions->where('status', 'success')
            ->groupBy(fn($t) => $t->user->name ?? 'Unknown')
            ->map(function ($group, $name) {
                return (object) [
                    'name' => $name,
                    'orders' => $group->count(),
                    'total_spent' => $group->sum('amount')
                ];
            })
            ->sortByDesc('total_spent')
            ->take(5)
            ->values();


        // COHORT
        $newUsersRevenue = $transactions
            ->where('status', 'success')
            ->filter(function ($t) use ($startDate, $endDate) {
                if (!$t->assigned_to_email)
                    return false;
                // Ideally we'd valid created_at of the email user, but optimizing:
                return true; // Simplified for collection
            })
            ->sum('amount');



        return compact('analytics', 'trend', 'currencyStats', 'spendingByDay', 'hourly', 'topProducts');
    }

    private function successRate($rows)
    {
        if ($rows->count() == 0)
            return 0;
        $success = $rows->where('status', 'success')->count();
        return round(($success / $rows->count()) * 100, 1);
    }



    private function getDaysFromRange($range)
    {
        return match ($range) {
            'Last 7 days' => 7,
            'Last 30 days' => 30,
            'Last 3 months' => 90,
            'Last 6 months' => 180,
            'Last year' => 365,
            default => 30
        };
    }
    private function logExport($userId, $type, $format, $fileName, $filePath)
    {
        ExportLog::create([
            'user_id' => $userId,
            'type' => $type,
            'format' => $format,
            'file_name' => $fileName,
            'file_path' => $filePath
        ]);
    }
}
