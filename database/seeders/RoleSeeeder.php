<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeeder extends Seeder
{

    public function run(): void
    {
        $roles = [
            ['name' => 'superadmin', 'label' => 'SUPER ADMIN'],
            ['name' => 'admin', 'label' => 'ADMINISTRATOR'],
            ['name' => 'user', 'label' => 'USER']
        ];

        foreach($roles as $role){
            Role::factory()->create($role);
        }
    }
}
