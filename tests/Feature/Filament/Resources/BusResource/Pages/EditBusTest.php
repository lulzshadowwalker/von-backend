<?php

namespace Tests\Feature\Filament\Resources\BusResource\Pages;

use App\Filament\Resources\BusResource;
use App\Filament\Resources\BusResource\Pages\EditBus;
use App\Models\Bus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\WithAdmin;

class EditBusTest extends TestCase
{
    use RefreshDatabase, WithAdmin;

    public function test_it_renders_the_page(): void
    {
        $bus = Bus::factory()->create();

        $this->get(BusResource::getUrl('edit', ['record' => $bus]))
            ->assertOk();
    }

    public function test_it_edits_bus(): void
    {
        $bus = Bus::factory()->create();
        $new = Bus::factory()->make();

        Livewire::test(EditBus::class, ['record' => $bus->getKey()])
            ->fillForm([
                'license_plate' => $new->license_plate,
                'capacity' => $new->capacity,
            ])
            ->call('save')
            ->assertHasNoErrors();

        $bus->refresh();
        $this->assertEquals($new->license_plate, $bus->license_plate);
        $this->assertEquals($new->capacity, $bus->capacity);
    }
}
