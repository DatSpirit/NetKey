<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'message',
        'status',
        'ip_address',
    ];

    /**
     * Ticket thuộc về một user (có thể null nếu khách vãng lai)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope lọc theo trạng thái
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }
}
