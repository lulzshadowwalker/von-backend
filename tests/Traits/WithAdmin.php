<?php

namespace Tests\Traits;

use App\Enums\Role;
use App\Models\User;

trait WithAdmin
{
    use WithAuthorization;

    public function setUpWithAdmin(): void
    {
        $this->setUpWithAuthorization();

        $user = User::factory()->create();

        $user->assignRole(Role::ADMIN);

        $this->actingAs($user);
    }
}
