<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rates = [
            ['name' => 'pwd_discount', 'percentage' => 0.20, 'status' => 'active'],
            ['name' => 'senior_discount', 'percentage' => 0.18,  'status' => 'active']
        ];

        foreach ($rates as $rate){
            Discount::factory()->create($rate);
        }
    }
}
