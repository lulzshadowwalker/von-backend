<?php

namespace Tests\Feature\Filament\Resources\BusResource\Pages;

use App\Filament\Resources\BusResource;
use App\Filament\Resources\BusResource\Pages\ListBuses;
use App\Models\Bus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\WithAdmin;

class ListBusesTest extends TestCase
{
    use RefreshDatabase, WithAdmin;

    public function test_it_renders_the_page(): void
    {
        $this->get(BusResource::getUrl('index'))
            ->assertOk();
    }

    public function test_page_contains_recrods(): void
    {
        $buses = Bus::factory()->count(5)->create();

        Livewire::test(ListBuses::class)
            ->assertCanSeeTableRecords($buses);
    }
}
