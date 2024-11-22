<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->post(route('api.auth.register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'deviceToken' => 'sample-token',
        ]);

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);

        $this->assertDatabaseHas('device_tokens', [
            'user_id' => 1,
            'token' => 'sample-token',
        ]);

        $this->assertDatabaseHas('passengers', [
            'user_id' => 1,
        ]);

        $this->assertStringContainsString('"token":', $response->content(), 'Token not found in response');
    }

    public function test_existing_users_cannot_register(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('api.auth.register'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'Pa$$w0rdALKSndlkn2131233lknsadlksn',
            'password_confirmation' => 'Pa$$w0rdALKSndlkn2131233lknsadlksn',
        ]);

        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
        $response->assertStatus(Response::HTTP_CONFLICT);
    }
}
