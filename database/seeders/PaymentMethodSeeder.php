<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethod = [
            [
                'name' => 'Gcash',
                'status' => 0
            ],
            [
                'name' => '711',
                'status' => 0
            ],
            [
                'name' => 'Credit Card',
                'status' => 0
            ],
            [
                'name' => 'Cash',
                'status' => 0
            ],
        ];

        PaymentMethod::insert($paymentMethod);
    }
}
