<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            ['name' => 'Executive', 'price' => 25000],
            ['name' => 'Queen Room', 'price' => 23000],
            ['name' => 'Deluxe Room', 'price' => 20000],
            ['name' => 'Double Room', 'price' => 18000],
            ['name' => 'Standard Room', 'price' => 10000]
        ];

        foreach($roomTypes as $roomType){
            RoomType::factory()->create($roomType);
        }
    }
}
