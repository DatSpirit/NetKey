<?php

namespace App\Services;

use App\Models\User;
use App\Models\DailyCheckin;
use App\Models\CheckinLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class DailyCheckinService
{
    // ==========================================
    // REWARD CONFIGURATION
    // ==========================================

    const BASE_REWARD = 10;

    // Các ngày lễ/đặc biệt trong năm (Tháng-Ngày)
    const SPECIAL_DAYS = [
        '01-01' => ['name' => 'Năm Mới', 'multiplier' => 2.0],
        '02-14' => ['name' => 'Valentine', 'multiplier' => 1.5],
        '03-08' => ['name' => 'Quốc Tế Phụ Nữ', 'multiplier' => 1.5],
        '04-30' => ['name' => 'Giải Phóng MN', 'multiplier' => 2.0],
        '05-01' => ['name' => 'Quốc Tế Lao Động', 'multiplier' => 2.0],
        '09-02' => ['name' => 'Quốc Khánh', 'multiplier' => 2.0],
        '10-20' => ['name' => 'Phụ Nữ VN', 'multiplier' => 1.5],
        '12-24' => ['name' => 'Giáng Sinh', 'multiplier' => 1.5],
        '12-25' => ['name' => 'Giáng Sinh', 'multiplier' => 1.5],
    ];

    /**
     * Kiểm tra trạng thái điểm danh hôm nay
     */
    public function canCheckin(User $user): array
    {
        $today = Carbon::today();
        $checkin = CheckinLog::where('user_id', $user->id)
            ->whereDate('checkin_date', $today)
            ->first();

        if ($checkin) {
            return [
                'can_checkin' => false,
                'reason' => 'already_checked_in',
            ];
        }

        $specialDay = $this->getSpecialDay($today);
        $reward = $this->calculateReward($user, $today);

        return [
            'can_checkin' => true,
            'reward' => $reward,
            'special_day' => $specialDay,
        ];
    }

    /**
     * Thực hiện điểm danh
     */
    public function checkin(User $user): array
    {
        $status = $this->canCheckin($user);

        if (!$status['can_checkin']) {
            throw new Exception('Bạn đã điểm danh hôm nay rồi!');
        }

        DB::beginTransaction();
        try {
            $today = Carbon::today();
            $reward = $status['reward'];
            $specialDay = $status['special_day'];

            // 1. Cập nhật Ví
            $wallet = $user->getOrCreateWallet();
            $wallet->deposit(
                amount: $reward,
                type: 'deposit',
                description: "Điểm danh ngày " . $today->format('d/m') . ($specialDay ? " ({$specialDay['name']})" : ""),
                referenceType: DailyCheckin::class,
                referenceId: 0 // Placeholder
            );

            // 2. Log điểm danh
            $log = CheckinLog::create([
                'user_id' => $user->id,
                'checkin_date' => $today,
                'reward_amount' => $reward,
                'streak_day' => 1, // Không dùng streak nữa, hoặc dùng cho logic khác
                'is_bonus' => !empty($specialDay),
                'bonus_type' => $specialDay['name'] ?? null,
                'notes' => $specialDay ? "Thưởng ngày lễ: {$specialDay['name']}" : null,
            ]);

            // 3. Cập nhật record tổng (Optional - để tracking tổng quan)
            $dailyCheckin = DailyCheckin::firstOrCreate(['user_id' => $user->id]);
            $dailyCheckin->increment('total_checkins');
            $dailyCheckin->increment('total_earned', $reward);
            $dailyCheckin->update(['last_checkin_date' => $today, 'last_checkin_at' => now()]);

            DB::commit();

            return [
                'success' => true,
                'reward' => $reward,
                'checkin_date' => $today->format('d/m/Y'),
                'special_day' => $specialDay,
            ];

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Lấy dữ liệu cho lịch tháng này
     */
    public function getMonthlyState(User $user, int $month, int $year): array
    {
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Lấy lịch sử điểm danh trong tháng
        $logs = CheckinLog::where('user_id', $user->id)
            ->whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->checkin_date)->day;
            });

        $calendar = [];
        $daysInMonth = $startOfMonth->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            $isToday = $date->isToday();
            $specialDay = $this->getSpecialDay($date);

            $status = 'pending'; // pending, checked, missed, future
            $log = $logs[$day] ?? null;

            if ($log) {
                $status = 'checked';
            } elseif ($date->isPast() && !$isToday) {
                $status = 'missed';
            } elseif ($isToday) {
                $status = 'today';
            } else {
                $status = 'future';
            }

            $calendar[] = [
                'day' => $day,
                'date' => $date->format('Y-m-d'),
                'is_today' => $isToday,
                'status' => $status,
                'special_day' => $specialDay,
                'reward' => $log ? $log->reward_amount : $this->calculateReward($user, $date),
            ];
        }

        return [
            'month' => $month,
            'year' => $year,
            'days' => $calendar,
            'start_day_of_week' => $startOfMonth->dayOfWeek, // 0 (Sun) - 6 (Sat)
        ];
    }

    private function getSpecialDay(Carbon $date): ?array
    {
        $key = $date->format('m-d');
        if (isset(self::SPECIAL_DAYS[$key])) {
            return self::SPECIAL_DAYS[$key];
        }
        return null;
    }

    private function calculateReward(User $user, Carbon $date): float
    {
        $reward = self::BASE_REWARD;
        $specialDay = $this->getSpecialDay($date);

        if ($specialDay) {
            $reward *= $specialDay['multiplier'];
        }

        return $reward;
    }
}