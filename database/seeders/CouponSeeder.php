<?php

namespace Database\Seeders;

use App\Models\Coupons\Coupon;
use Illuminate\Database\Seeder;
use App\Models\Coupons\FixedValueCoupon;
use App\Models\Coupons\PercentOffCoupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $percent = PercentOffCoupon::create([
            'percent_off' => 10
        ]);
        $fixed = FixedValueCoupon::create([
            'value' => 2000
        ]);
        Coupon::create([
            'code' => 'ABC123',
            'couponable_id' => $percent->id,
            'couponable_type' => get_class($percent)
        ]);
        Coupon::create([
            'code' => 'DEF456',
            'couponable_id' => $fixed->id,
            'couponable_type' => get_class($fixed)
        ]);
    }
}
