<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\Traits\WithAuthorization;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase, WithAuthorization;

    public function test_new_users_can_register(): void
    {
        $response = $this->post(route('api.auth.register'), [
            'data' => [
                'attributes' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => 'password',
                    'passwordConfirmation' => 'password',
                    'deviceToken' => 'sample-token',
                    'avatar' => 'data:image/jpeg;base64,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',
                    'deviceName' => 'Lulzie\'s iPhone',
                ]
            ]
        ], ['Accept' => 'application/vnd.api+json']);

        $response->assertStatus(Response::HTTP_CREATED);

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

        $this->assertNotNull($avatar = User::first()->avatarFile);

        $avatar->delete();

        $this->assertEquals('Lulzie\'s iPhone', Auth::user()->tokens->first()->name);
    }

    public function test_existing_users_cannot_register(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('api.auth.register'), [
            'data' => [
                'attributes' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => 'Pa$$w0rdALKSndlkn2131233lknsadlksn',
                    'passwordConfirmation' => 'Pa$$w0rdALKSndlkn2131233lknsadlksn',
                ]
            ]
        ]);

        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
        $response->assertStatus(Response::HTTP_CONFLICT);
    }
}
