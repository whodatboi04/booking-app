<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['create' , 'read', 'update', 'delete', 'restore']),
            'ability' => fake()->randomElement(['can:create', 'can:read', 'can:update', 'can:delete', 'can:restore']),
            'label' => fake()->randomElement(['Can Create', 'Can Read', 'Can Update', 'Can Delete', 'Can Restore'])
        ];
    }
}
