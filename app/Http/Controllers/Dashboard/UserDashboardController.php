<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
class UserDashboardController extends Controller
{
    /**
     * Hiển thị trang cá nhân (Dashboard) của người dùng đã đăng nhập.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $now = now();

        // ----------------------------------------------------
        // 1. THỐNG KÊ GIAO DỊCH VÀ CHI TIÊU
        // ----------------------------------------------------
        $allTransactions = Transaction::where('user_id', $userId)->get();

        $transactionStats = $allTransactions->groupBy('status')->map->count();

        $totalSpend = $allTransactions->where('status', 'success')->sum('amount');
        $totalTransactions = $allTransactions->count();

        $stats = [
            'total_spend' => $totalSpend,
            'total_transactions' => $totalTransactions,
            'success' => $transactionStats->get('success', 0),
            'pending' => $transactionStats->get('pending', 0),
            'failed' => $transactionStats->get('failed', 0) + $transactionStats->get('cancelled', 0),
        ];

        // ----------------------------------------------------
        // 2. SẢN PHẨM ĐÃ MUA GẦN ĐÂY 
        // ----------------------------------------------------
        $productsBought = Transaction::with('product')
            ->where('user_id', $userId)
            ->where('status', 'success')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ----------------------------------------------------
        // 3. HOẠT ĐỘNG GẦN ĐÂY 
        // ----------------------------------------------------
        $activities = [];

        if (property_exists($user, 'last_login_at') && $user->last_login_at) {
            $activities[] = [
                'desc' => "Đăng nhập thành công",
                'time' => $user->last_login_at->diffForHumans($now),
                'icon' => '🔑',
                'color' => 'indigo',
                'real_time' => $user->last_login_at,
            ];
        } else {
            $activities[] = [
                'desc' => "Tài khoản được tạo",
                'time' => $user->created_at->diffForHumans($now),
                'icon' => '🎉',
                'color' => 'emerald',
                'real_time' => $user->created_at,
            ];
        }

        if ($latestSuccess = $productsBought->first()) {
            $activities[] = [
                'desc' => "Hoàn tất thanh toán đơn hàng #{$latestSuccess->order_code}",
                'time' => $latestSuccess->created_at->diffForHumans($now),
                'icon' => '💰',
                'color' => 'green',
                'real_time' => $latestSuccess->created_at,
            ];
        }

        if ($user->updated_at->gt($user->created_at)) {
            $activities[] = [
                'desc' => "Cập nhật hồ sơ cá nhân",
                'time' => $user->updated_at->diffForHumans($now),
                'icon' => '✍️',
                'color' => 'purple',
                'real_time' => $user->updated_at,
            ];
        }

        usort($activities, fn($a, $b) => $b['real_time'] <=> $a['real_time']);
        $activities = array_slice($activities, 0, 4);

        // ====================================================
        // 4. LOGIC TÍNH TOÁN DỮ LIỆU BIỂU ĐỒ (KẾT HỢP ANALYTICS)
        // ====================================================

        // Lấy tham số range, mặc định là '7days'
        $range = $request->get('range', '7days'); // 7days | month | year

        // Khởi tạo các mảng dữ liệu biểu đồ
        $chartLabels = [];
        $chartTotals = [];
        $chartCounts = [];

        // ----------------------------------------------------
        // XỬ LÝ PHẠM VI 7 NGÀY
        // ----------------------------------------------------
        if ($range === '7days') {
            $start = now()->subDays(6)->startOfDay();
            $end = now()->endOfDay();

            // Truy vấn giao dịch thành công của người dùng trong 7 ngày
            $transactions = Transaction::where('user_id', $userId)
                ->where('status', 'success')
                ->whereBetween('created_at', [$start, $end])
                ->get()
                ->groupBy(fn($t) => $t->created_at->format('d/m'));

            // Duyệt qua từng ngày trong phạm vi
            foreach (CarbonPeriod::create($start, $end) as $date) {
                $key = $date->format('d/m');
                $chartLabels[] = "Day {$key}";

                $dayTransactions = $transactions->get($key, collect());

                $chartTotals[] = $dayTransactions->sum('amount');
                $chartCounts[] = $dayTransactions->count();
            }
        }

        // ----------------------------------------------------
        // XỬ LÝ PHẠM VI THÁNG HIỆN TẠI
        // ----------------------------------------------------
        elseif ($range === 'month') {
            $daysInMonth = now()->daysInMonth;
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();

            // Truy vấn giao dịch thành công của người dùng trong tháng
            $transactions = Transaction::where('user_id', $userId)
                ->where('status', 'success')
                ->whereBetween('created_at', [$start, $end])
                ->get()
                ->groupBy(fn($t) => $t->created_at->format('d'));

            // Duyệt qua từng ngày trong tháng
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $key = str_pad($i, 2, '0', STR_PAD_LEFT);
                $chartLabels[] = "Day {$key}";

                $dayTransactions = $transactions->get($key, collect());

                $chartTotals[] = $dayTransactions->sum('amount');
                $chartCounts[] = $dayTransactions->count();
            }
        }

        // ----------------------------------------------------
        // XỬ LÝ PHẠM VI NĂM HIỆN TẠI
        // ----------------------------------------------------
        elseif ($range === 'year') {
            // Truy vấn giao dịch thành công của người dùng trong năm
            $transactions = Transaction::where('user_id', $userId)
                ->where('status', 'success')
                ->whereYear('created_at', now()->year)
                ->get()
                ->groupBy(fn($t) => $t->created_at->format('m'));

            // Duyệt qua 12 tháng
            for ($m = 1; $m <= 12; $m++) {
                $key = str_pad($m, 2, '0', STR_PAD_LEFT);
                $chartLabels[] = "Amount {$m}";

                $monthTransactions = $transactions->get($key, collect());

                $chartTotals[] = $monthTransactions->sum('amount');
                $chartCounts[] = $monthTransactions->count();
            }
        }

        // ----------------------------------------------------
        // TRẢ VỀ VIEW
        // ----------------------------------------------------
        return view('dashboard.user', [
            'user' => $user,
            'stats' => $stats,
            'productsBought' => $productsBought,
            'activities' => $activities,
            // Sử dụng dữ liệu biểu đồ đã tính toán chi tiết
            'chartLabels' => $chartLabels,
            'chartTotals' => $chartTotals,
            'chartCounts' => $chartCounts,
            'currentRange' => $range, // Thêm range để hiển thị trạng thái đang xem
        ]);
    }
}
