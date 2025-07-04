<?php

namespace Tests\Feature\Auth;

use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthenticatedSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('api.auth.login'), [
            'data' => [
                'attributes' => [
                    'email' => $user->email,
                    'password' => 'password',
                    'deviceName' => 'Lulzie\'s iPhone',
                ],
            ]
        ]);

        $this->assertAuthenticated();
        $this->assertStringContainsString('"token":', $response->content(), 'Token not found in response');
        $this->assertEquals('Lulzie\'s iPhone', Auth::user()->tokens()->first()->name);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post(route('api.auth.login'), [
            'data.attributes.email' => $user->email,
            'data.attributes.password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()
            ->has(DeviceToken::factory()->count(1)->state(['token' => 'sample-token']))
            ->create();

        $response = $this->actingAs($user)->post(route('api.auth.logout'), [
            'data' => [
                'attributes' => [
                    'deviceToken' => 'sample-token',
                ],
            ]
        ], [
            'Authorization' => 'Bearer ' . $user->createToken('authToken')->plainTextToken,
            'Accept' => 'application/json',
        ]);

        $response->assertOk();

        $user->refresh();
        $this->assertCount(0, $user->deviceTokens);
    }

    public function test_it_returns_an_error_if_device_token_is_provided_but_non_existent(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('api.auth.logout'), [
            'data' => [
                'attributes' => [
                    'deviceToken' => 'non-existent-token',
                ],
            ]
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->createToken('authToken')->plainTextToken,
        ]);

        $response->assertNotFound();
    }
}
