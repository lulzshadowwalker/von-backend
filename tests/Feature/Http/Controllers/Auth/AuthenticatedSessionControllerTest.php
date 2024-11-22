<?php

namespace Tests\Feature\Auth;

use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertStringContainsString('"token":', $response->content(), 'Token not found in response');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()
            ->has(DeviceToken::factory()->count(1)->state(['token' => 'sample-token']))
            ->create();

        $response = $this->actingAs($user)->post('/logout', [
            'deviceToken' => 'sample-token',
        ]);

        $user->refresh();
        $this->assertCount(0, $user->deviceTokens);

        $this->assertGuest();
        $response->assertOk();
    }

    public function test_it_returns_an_error_if_device_token_is_provided_but_non_existent(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout', [
            'deviceToken' => 'non-existent-token',
        ]);

        $response->assertNotFound();
    }
}
