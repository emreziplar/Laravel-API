<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->post('api/v1/register', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(201);
    }
}
