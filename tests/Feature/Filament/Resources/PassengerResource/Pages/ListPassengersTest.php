<?php

namespace Tests\Feature\Filament\Resources\PassengerResource\Pages;

use App\Filament\Resources\PassengerResource;
use App\Filament\Resources\PassengerResource\Pages\ListPassengers;
use App\Models\Passenger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\WithAdmin;

class ListPassengersTest extends TestCase
{
    use RefreshDatabase, WithAdmin;

    public function test_it_renders_the_page(): void
    {
        $this->get(PassengerResource::getUrl('index'))
            ->assertOk();
    }

    public function test_page_contains_records(): void
    {
        $passengers = Passenger::factory()->count(5)->create();

        Livewire::test(ListPassengers::class)
            ->assertCanSeeTableRecords($passengers);
    }
}
