<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call([
            CouponSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
        \App\Models\User::factory(10)->hasBillingDetails()->create();
    }
}
