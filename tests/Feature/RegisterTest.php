<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    
    public function test_account_registration_if_success(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'username' => 'newuser23123',
            'email' => 'newuser21312@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'message' => 'Registration successful',
        ]);

        $user = User::where('email', 'newuser21312@gmail.com')->first();

        $this->assertDatabaseHas('users', [
            'username' => 'newuser23123',
            'email' => 'newuser21312@gmail.com',
        ]);

        $this->assertDatabaseHas('user_infos', [
            'user_id' => $user->id,
        ]);
    }

}
