<?php

namespace Tests\Feature\Contracts;

use App\Enums\Role;
use App\Http\Resources\DriverResource;
use App\Http\Resources\PassengerResource;
use App\Models\Driver;
use App\Models\Passenger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\WithAuthorization;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithAuthorization;

    public function test_it_returns_a_passenger_profile()
    {
        $passenger = Passenger::factory()->create();
        $passenger->user->assignRole(Role::PASSENGER);
        $this->actingAs($passenger->user);
        $resource = PassengerResource::make($passenger);

        $this->get(route('api.profile.index'))
            ->assertOk()
            ->assertExactJson($resource->response()->getData(true));
    }

    public function test_it_returns_a_driver_profile()
    {
        $driver = Driver::factory()->create();
        $driver->user->assignRole(Role::DRIVER);
        $this->actingAs($driver->user);
        $resource = DriverResource::make($driver);

        $this->get(route('api.profile.index'))
            ->assertOk()
            ->assertExactJson($resource->response()->getData(true));
    }
}
