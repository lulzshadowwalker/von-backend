<?php

namespace Tests\Feature\Filament\Resources\BusResource\Pages;

use App\Filament\Resources\BusResource;
use App\Filament\Resources\BusResource\Pages\CreateBus;
use App\Models\Bus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\WithAdmin;

class CreateBusTest extends TestCase
{
    use RefreshDatabase, WithAdmin;

    public function test_it_renders_the_page(): void
    {
        $this->get(BusResource::getUrl('create'))
            ->assertOk();
    }

    public function test_it_creates_bus(): void
    {
        $bus = Bus::factory()->make();

        Livewire::test(CreateBus::class)
            ->fillForm([
                'license_plate' => $bus->license_plate,
                'capacity' => $bus->capacity,
            ])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('buses', [
            'license_plate' => $bus->license_plate,
            'capacity' => $bus->capacity,
        ]);
    }
}
