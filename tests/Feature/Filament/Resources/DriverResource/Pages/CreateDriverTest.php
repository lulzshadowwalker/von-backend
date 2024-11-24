<?php

namespace Tests\Feature\Filament\Resources\DriverResource\Pages;

use App\Filament\Resources\DriverResource;
use App\Filament\Resources\DriverResource\Pages\CreateDriver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\WithAdmin;

class CreateDriverTest extends TestCase
{
    use RefreshDatabase, WithAdmin;

    public function test_it_renders_the_page(): void
    {
        $this->get(DriverResource::getUrl('create'))
            ->assertOk();
    }

    public function test_it_creates_driver(): void
    {
        $user = User::factory()->make();

        Livewire::test(CreateDriver::class)
            ->fillForm([
                'user.name' => $user->name,
                'user.email' => $user->email,
            ])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $this->assertDatabaseHas('drivers', [
            'user_id' => User::whereEmail($user->email)->first()->id,
        ]);
    }
}
