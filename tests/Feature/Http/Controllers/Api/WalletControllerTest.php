<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\Role;
use App\Http\Resources\WalletResource;
use App\Models\Passenger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\WithAuthorization;

class WalletControllerTest extends TestCase
{
    use RefreshDatabase, WithAuthorization;

    public function test_show_wallet(): void
    {
        $passenger = Passenger::factory()->create();
        $passenger->user->assignRole(Role::PASSENGER);
        $passenger->wallet->deposit(0); //  HACK: This creates a wallet for the passenger

        $resource = WalletResource::make($passenger->wallet);
        $this->actingAs($passenger->user);

        $this->getJson(route('api.wallets.show', ['wallet' => $passenger->wallet]))
            ->assertOk()
            ->assertExactJson($resource->response()->getData(true));
    }

    public function test_a_user_cannot_view_another_user_wallet(): void
    {
        $passenger = Passenger::factory()->create();
        $passenger->user->assignRole(Role::PASSENGER);
        $passenger->wallet->deposit(0); //  HACK: This creates a wallet for the passenger

        $anotherPassenger = Passenger::factory()->create();
        $anotherPassenger->user->assignRole(Role::PASSENGER);
        $anotherPassenger->wallet->deposit(0); //  HACK: This creates a wallet for the passenger

        $this->actingAs($passenger->user);

        $this->getJson(route('api.wallets.show', ['wallet' => $anotherPassenger->wallet]))
            ->assertForbidden();
    }
}
