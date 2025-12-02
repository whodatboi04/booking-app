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
            [
                'name' => 'Executive',
                'price' => 25000,
                'description' => 'The Executive Room offers a stylish, comfortable space with premium amenities, ideal for business travelers seeking both productivity and relaxation.',
                'room_capacity' => 2,
                'room_image' => 'https://example.com/images/executive-room.jpg'
            ],
            [
                'name' => 'Queen Room',
                'price' => 23000,
                'description' => 'The Queen Room features a comfortable queen-sized bed, modern décor, and essential amenities, perfect for solo travelers or couples seeking a relaxing stay.',
                'room_capacity' => 2,
                'room_image' => 'https://example.com/images/queen-room.jpg'
            ],
            [
                'name' => 'Deluxe Room',
                'price' => 20000,
                'description' => 'The Deluxe Room offers extra space, elegant décor, and upgraded amenities, providing a comfortable and refined stay for guests seeking added luxury.',
                'room_capacity' => 3,
                'room_image' => 'https://example.com/images/deluxe-room.jpg'
            ],
            [
                'name' => 'Double Room',
                'price' => 18000,
                'description' => 'The Double Room features two comfortable beds and essential amenities, ideal for friends or family traveling together.',
                'room_capacity' => 4,
                'room_image' => 'https://example.com/images/double-room.jpg'
            ],
            [
                'name' => 'Standard Room',
                'price' => 10000,
                'description' => 'The Standard Room offers a cozy and practical space with all the essential amenities, perfect for a comfortable and convenient stay.',
                'room_capacity' => 2,
                'room_image' => 'https://example.com/images/standard-room.jpg'
            ]
        ];


        foreach ($roomTypes as $roomType) {
            RoomType::factory()->create($roomType);
        }
    }
}
