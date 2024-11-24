<?php

namespace Tests\Feature\Filament\Resources\DriverResource\Pages;

use App\Filament\Resources\DriverResource;
use App\Filament\Resources\DriverResource\Pages\ListDrivers;
use App\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\WithAdmin;

class ListDriversTest extends TestCase
{
    use RefreshDatabase, WithAdmin;

    public function test_it_renders_the_page(): void
    {
        $this->get(DriverResource::getUrl('index'))
            ->assertOk();
    }

    public function test_page_contains_records(): void
    {
        $drivers = Driver::factory()->count(5)->create();

        Livewire::test(ListDrivers::class)
            ->assertCanSeeTableRecords($drivers);
    }
}
