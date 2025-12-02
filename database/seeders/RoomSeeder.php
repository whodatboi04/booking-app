<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $roomNo) {
            Room::factory()->create([
                'room_no' => $roomNo,
                'room_type_id' => fake()->numberBetween(1, 5)
            ]);
        }
    }
}
