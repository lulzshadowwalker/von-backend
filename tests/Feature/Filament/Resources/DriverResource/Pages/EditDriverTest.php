<?php

namespace Tests\Feature\Filament\Resources\DriverResource\Pages;

use App\Filament\Resources\DriverResource;
use App\Filament\Resources\DriverResource\Pages\EditDriver;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\WithAdmin;

class EditDriverTest extends TestCase
{
    use RefreshDatabase, WithAdmin;

    public function test_it_renders_the_page(): void
    {
        $driver = Driver::factory()->create();

        $this->get(DriverResource::getUrl('edit', ['record' => $driver->getKey()]))
            ->assertOk();
    }

    public function test_it_edits_driver(): void
    {
        $driver = Driver::factory()->create();

        $new = User::factory()->make();

        Livewire::test(EditDriver::class, ['record' => $driver->getKey()])
            ->fillForm([
                'user.name' => $new->name,
                'user.email' => $new->email,
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => $new->name,
            'email' => $new->email,
        ]);

        $this->assertDatabaseHas('drivers', [
            'user_id' => User::whereEmail($new->email)->first()->getKey(),
        ]);

        $this->assertCount(1, Driver::all());

        $this->assertCount(2, User::all(), 'There should be 2 users in the database including the admin we are testing with.');
    }
}
