<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyCheckin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_streak',
        'longest_streak',
        'total_checkins',
        'total_earned',
        'last_checkin_date',
        'last_checkin_at',
        'milestone_rewards',
    ];

    protected $casts = [
        'last_checkin_date' => 'date',
        'last_checkin_at' => 'datetime',
        'milestone_rewards' => 'array',
        'total_earned' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
