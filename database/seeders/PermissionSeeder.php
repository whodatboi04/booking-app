<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'create', 'ability' => 'can:create', 'label' => 'CAN CREATE'],
            ['name' => 'read', 'ability' => 'can:read', 'label' => 'CAN READ'],
            ['name' => 'update', 'ability' => 'can:update', 'label' => 'CAN UPDATE'],
            ['name' => 'delete', 'ability' => 'can:delete', 'label' => 'CAN DELETE'],
            ['name' => 'restore', 'ability' => 'can:restore', 'label' => 'CAN RESTORE'],
            ['name' => 'assign', 'ability' => 'can:assign', 'label' => 'CAN ASSIGN'],
            ['name' => 'accept-payment', 'ability' => 'can:accept-payment', 'label' => 'CAN ACCEPT PAYMENT'],
            ['name' => 'decline-payment', 'ability' => 'can:decline-payment', 'label' => 'CAN DECLINE PAYMENT'],
        ];

        foreach($permissions as $permission){
            Permission::factory()->create($permission);
        }
    }
}
