<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_Register_User_With_Valid_Data()
    {
        $response = $this->post('api/register', [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_Register_User_With_Invalid_Data()
    {
        $response = $this->post('api/register', [
            'name'                  => '',
            'email'                 => 'invalid-email',
            'password'              => 'short',
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
