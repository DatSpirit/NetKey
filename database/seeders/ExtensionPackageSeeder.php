<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ExtensionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Gói Gia Hạn 1 Ngày',
                'description' => 'Gia hạn thời gian sử dụng tài khoản thêm 1 ngày. Trải nghiệm ngay các tính năng VIP.',
                'price' => 10000,
                'coinkey_amount' => 20000,
                'duration_minutes' => 1 * 1440, // 1 day
                'sort_order' => 1,
            ],
            [
                'name' => 'Gói Gia Hạn 3 Ngày',
                'description' => 'Gia hạn thời gian sử dụng tài khoản thêm 3 ngày. Tiết kiệm hơn so với mua lẻ.',
                'price' => 25000,
                'coinkey_amount' => 50000,
                'duration_minutes' => 3 * 1440, // 3 days
                'sort_order' => 2,
            ],
            [
                'name' => 'Gói Gia Hạn 7 Ngày',
                'description' => 'Gia hạn thời gian sử dụng tài khoản thêm 7 ngày. Tuần lễ trải nghiệm trọn vẹn.',
                'price' => 50000,
                'coinkey_amount' => 100000,
                'duration_minutes' => 7 * 1440, // 7 days
                'sort_order' => 3,
            ],
            [
                'name' => 'Gói Gia Hạn 30 Ngày',
                'description' => 'Gia hạn thời gian sử dụng tài khoản thêm 30 ngày. Giải pháp tiết kiệm cho cả tháng.',
                'price' => 150000,
                'coinkey_amount' => 300000,
                'duration_minutes' => 30 * 1440, // 30 days
                'sort_order' => 4,
            ],
            [
                'name' => 'Gói Gia Hạn 90 Ngày',
                'description' => 'Gia hạn thời gian sử dụng tài khoản thêm 90 ngày. Thỏa sức sử dụng 3 tháng liên tục.',
                'price' => 400000,
                'coinkey_amount' => 800000,
                'duration_minutes' => 90 * 1440, // 90 days
                'sort_order' => 5,
            ],
            [
                'name' => 'Gói Gia Hạn 180 Ngày',
                'description' => 'Gia hạn thời gian sử dụng tài khoản thêm 180 ngày. Nửa năm sử dụng không lo gián đoạn.',
                'price' => 700000,
                'coinkey_amount' => 1400000,
                'duration_minutes' => 180 * 1440, // 180 days
                'sort_order' => 6,
            ],
            [
                'name' => 'Gói Gia Hạn 365 Ngày',
                'description' => 'Gia hạn thời gian sử dụng tài khoản thêm 365 ngày. Siêu tiết kiệm, trọn vẹn một năm.',
                'price' => 1200000,
                'coinkey_amount' => 2400000,
                'duration_minutes' => 365 * 1440, // 365 days
                'sort_order' => 7,
            ],
        ];

        foreach ($packages as $pkg) {
            // Check if exists
            $exists = Product::where('name', $pkg['name'])
                ->where('product_type', 'package')
                ->exists();

            if (!$exists) {
                $p = Product::create([
                    'name' => $pkg['name'],
                    'category' => 'vip_package', // Required for Controller filter
                    'price' => $pkg['price'],
                    'description' => $pkg['description'],
                    'product_type' => 'package',
                    'coinkey_amount' => $pkg['coinkey_amount'],
                    'duration_minutes' => $pkg['duration_minutes'],
                    'is_active' => true,
                ]);

                // Try to force fill sort_order
                try {
                    $p->forceFill(['sort_order' => $pkg['sort_order']])->save();
                } catch (\Exception $e) {
                    // Ignore if column doesn't exist
                }
            } else {
                // Update
                $p = Product::where('name', $pkg['name'])->first();
                $p->update([
                    'category' => 'vip_package',
                    'price' => $pkg['price'],
                    'description' => $pkg['description'],
                    'coinkey_amount' => $pkg['coinkey_amount'],
                    'duration_minutes' => $pkg['duration_minutes'],
                    'is_active' => true,
                ]);
                try {
                    $p->forceFill(['sort_order' => $pkg['sort_order']])->save();
                } catch (\Exception $e) {
                    // Ignore
                }
            }
        }
    }
}
