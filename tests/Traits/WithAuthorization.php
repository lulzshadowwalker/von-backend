<?php

namespace Tests\Traits;

use Database\Seeders\AuthorizationSeeder;

trait WithAuthorization
{
    public function setUpWithAuthorization(): void
    {
        $this->seed(AuthorizationSeeder::class);
    }
}
