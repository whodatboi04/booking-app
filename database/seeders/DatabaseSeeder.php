<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user = User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        $user->user_info()
            ->create([
                'firstname' => 'User',
                'lastname' => 'Test',
                'phone' => '09789456123',
                'birthdate' => '2001-10-04',
                'profile_picture' => 'test',
            ]);

        $this->call([
            RoleSeeeder::class,
            PermissionSeeder::class,
            UserRoleSeeder::class,
            RolePermissionSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            DiscountSeeder::class,
            PaymentMethodSeeder::class
        ]);
    }
}
