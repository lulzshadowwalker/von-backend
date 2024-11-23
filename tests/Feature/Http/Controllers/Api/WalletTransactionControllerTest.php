<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\Role;
use App\Http\Resources\TransactionResource;
use App\Models\Passenger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\WithAuthorization;

class WalletTransactionControllerTest extends TestCase
{
    use RefreshDatabase, WithAuthorization;

    public function test_show_all_wallet_transactions(): void
    {
        $passenger = Passenger::factory()->create();
        $passenger->user->assignRole(Role::PASSENGER);
        $passenger->wallet->deposit(100);
        $passenger->wallet->withdraw(20);

        $resource = TransactionResource::collection($passenger->wallet->transactions);
        $this->actingAs($passenger->user);

        $this->getJson(route('api.wallets.transactions.index', ['wallet' => $passenger->wallet]))
            ->assertOk()
            ->assertExactJson($resource->response()->getData(true));
    }

    public function test_show_wallet_transaction(): void
    {
        $passenger = Passenger::factory()->create();
        $passenger->user->assignRole(Role::PASSENGER);
        $passenger->wallet->deposit(100);
        $transaction = $passenger->wallet->withdraw(20);

        $resource = TransactionResource::make($transaction);
        $this->actingAs($passenger->user);

        $this->getJson(route('api.wallets.transactions.show', ['wallet' => $passenger->wallet, 'transaction' => $transaction]))
            ->assertOk()
            ->assertExactJson($resource->response()->getData(true));
    }

    public function test_cannot_view_another_user_transactions(): void
    {
        $passenger = Passenger::factory()->create();
        $passenger->user->assignRole(Role::PASSENGER);
        $passenger->wallet->deposit(100);

        $anotherPassenger = Passenger::factory()->create();
        $anotherPassenger->user->assignRole(Role::PASSENGER);
        $anotherPassenger->wallet->deposit(50);

        $this->actingAs($passenger->user);

        $this->getJson(route('api.wallets.transactions.index', ['wallet' => $anotherPassenger->wallet]))
            ->assertForbidden();
    }

    public function test_cannot_view_another_user_transaction(): void
    {
        $passenger = Passenger::factory()->create();
        $passenger->user->assignRole(Role::PASSENGER);
        $passenger->wallet->deposit(100);

        $anotherPassenger = Passenger::factory()->create();
        $anotherPassenger->user->assignRole(Role::PASSENGER);
        $anotherPassenger->wallet->deposit(50);
        $transaction = $anotherPassenger->wallet->withdraw(20);

        $this->actingAs($passenger->user);

        $this->getJson(route('api.wallets.transactions.show', ['wallet' => $anotherPassenger->wallet, 'transaction' => $transaction]))
            ->assertForbidden();
    }
}
