<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminAuditLog extends Model
{
    protected $fillable = [
        'admin_id',
        'action',
        'target_type',
        'target_id',
        'description',
        'ip_address',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Log thuộc về Admin
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Static helper để ghi log từ bất kỳ đâu
     *
     * @param string $action       Tên hành động (vd: 'suspend_user')
     * @param string $targetType   Loại đối tượng (vd: 'User', 'ProductKey')
     * @param int|null $targetId   ID của đối tượng
     * @param string $description  Mô tả ngắn gọn
     * @param array $old           Giá trị cũ (trước khi thay đổi)
     * @param array $new           Giá trị mới (sau khi thay đổi)
     */
    public static function log(
        string $action,
        string $targetType,
        ?int $targetId,
        string $description,
        array $old = [],
        array $new = []
    ): self {
        return static::create([
            'admin_id'    => Auth::id(),
            'action'      => $action,
            'target_type' => $targetType,
            'target_id'   => $targetId,
            'description' => $description,
            'ip_address'  => Request::ip(),
            'old_values'  => empty($old) ? null : $old,
            'new_values'  => empty($new) ? null : $new,
        ]);
    }
}
