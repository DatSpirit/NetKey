<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'description',
        'image',
        'product_type',      // 'coinkey' hoặc 'package'
        'coinkey_amount',    // Số lượng Coinkey nhận được (nếu nạp) HOẶC Giá bán bằng Coinkey (nếu là gói)
        'duration_minutes',  // Chỉ dùng cho 'package'
        'is_active'
    ];

    // Trả về URL công khai của ảnh sản phẩm (hoặc null nếu không có)
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->image) : null;
    }

    protected $casts = [
        'price' => 'decimal:2',
        'coinkey_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // --- Helper Methods ---

    // Kiểm tra đây có phải là gói nạp tiền không
    public function isCoinkeyPack(): bool
    {
        return $this->product_type === 'coinkey';
    }

    // Kiểm tra đây có phải là gói dịch vụ (Key) không
    public function isServicePackage(): bool
    {
        return $this->product_type === 'package';
    }

    // Kiểm tra xem sản phẩm này có phải là gói GIA HẠN tài khoản không (Logic mới)
    public function isExtensionPackage(): bool
    {
        // Kiểm tra dựa trên tên sản phẩm có chứa từ khóa 'Gia hạn' hoặc 'Extend'
        return $this->isServicePackage() &&
            (\Illuminate\Support\Str::contains($this->name, ['Gia hạn', 'Extend'], true) ||
                $this->category === 'Extension');
    }

    // Kiểm tra xem sản phẩm này có cho phép thanh toán bằng Ví không
    public function allowWalletPayment(): bool
    {
        // Gói nạp Coinkey thì KHÔNG được mua bằng Ví (tránh loop)
        // Gói dịch vụ phải có giá Coinkey set > 0
        return $this->isServicePackage() && $this->coinkey_amount > 0;
    }

    // --- VIP Logic Helpers (Centralized) ---

    // Tính level VIP yêu cầu dựa trên giá (Logic từ CoinkeyWalletController)
    public function getRequiredVipLevelAttribute(): int
    {
        // Price reference matches CoinkeyWalletController logic
        if ($this->price >= 500000)
            return 3;
        if ($this->price >= 200000)
            return 2;
        if ($this->price >= 100000)
            return 1;
        return 0;
    }

    // Tính % giảm giá dựa trên VIP Level yêu cầu (Logic hiển thị trên Shop)
    public function getVipDiscountPercentAttribute(): int
    {
        return match ($this->required_vip_level) {
            0 => 50,
            1 => 75,
            2 => 85,
            3 => 90,
            default => 0,
        };
    }
}