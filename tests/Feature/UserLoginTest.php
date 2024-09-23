<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_User_Login()
    {
        $user = User::factory()->create([
            'name'     => 'damir',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('api/login', [
            'login'    => 'damir',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Login successful',
            ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_User_Cant_Login_With_Wrong_Data()
    {
        User::factory()->create([
            'name'     => 'damir',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('api/login', [
            'login'    => 'damir',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status'  => 'error',
                'message' => 'Invalid login or password',
            ]);

        $this->assertGuest();
    }

    public function test_User_Requires_Login_And_Password()
    {
        $response = $this->postJson('api/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['login', 'password']);
    }

    public function test_User_Logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Logout successful',
            ]);

        $this->assertGuest();
    }
}
