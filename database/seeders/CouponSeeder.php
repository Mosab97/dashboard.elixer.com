<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => '10OFF',
            'discount' => 10,
            'expiry_date' => now()->addDays(30),
            'active' => true,
        ]);
    }
}
