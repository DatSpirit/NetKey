<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Services\DailyCheckinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyCheckinController extends Controller
{
    protected DailyCheckinService $checkinService;

    public function __construct(DailyCheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }

    /**
     * Trang điểm danh
     */
    public function index()
    {
        $user = Auth::user();
        $stats = $this->checkinService->getStats($user);
        $history = $this->checkinService->getHistory($user, 30);

        return view('checkin.index', compact('stats', 'history'));
    }

    /**
     * Xử lý điểm danh
     */
    public function checkin()
    {
        try {
            $user = Auth::user();
            $result = $this->checkinService->checkin($user);

            return response()->json([
                'success' => true,
                'message' => '🎉 Điểm danh thành công!',
                'data' => $result,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * API: Kiểm tra trạng thái điểm danh
     */
    public function status()
    {
        $user = Auth::user();
        $canCheckin = $this->checkinService->canCheckin($user);
        $stats = $this->checkinService->getStats($user);

        return response()->json([
            'success' => true,
            'can_checkin' => $canCheckin,
            'stats' => $stats,
        ]);
    }
}