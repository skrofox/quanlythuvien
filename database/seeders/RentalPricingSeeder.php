<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RentalPricing;

class RentalPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pricings = [
            [
                'period_days' => 7,
                'name' => '7 ngày',
                'price' => 50000,
                'description' => 'Gói mượn sách 7 ngày',
                'is_active' => true,
            ],
            [
                'period_days' => 14,
                'name' => '14 ngày',
                'price' => 90000,
                'description' => 'Gói mượn sách 14 ngày',
                'is_active' => true,
            ],
            [
                'period_days' => 30,
                'name' => '1 tháng',
                'price' => 150000,
                'description' => 'Gói mượn sách 1 tháng',
                'is_active' => true,
            ],
            [
                'period_days' => 365,
                'name' => '1 năm',
                'price' => 1500000,
                'description' => 'Gói mượn sách 1 năm',
                'is_active' => true,
            ],
        ];

        foreach ($pricings as $pricing) {
            RentalPricing::create($pricing);
        }
    }
}
