<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckinLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'checkin_date',
        'reward_amount',
        'streak_day',
        'is_bonus',
        'bonus_type',
        'notes',
    ];

    protected $casts = [
        'checkin_date' => 'date',
        'is_bonus' => 'boolean',
        'reward_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
