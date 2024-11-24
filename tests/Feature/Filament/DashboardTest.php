<?php

namespace Tests\Feature\Filament;

use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\WithAdmin;

class DashboardTest extends TestCase
{
    use RefreshDatabase, WithAdmin;

    public function test_it_renders_the_page(): void
    {
        $this->get(Filament::getUrl())->assertOk();
    }

    public function test_it_redirects_authenticated_users_from_the_root_route_to_the_dashboard_page(): void
    {
        $this->get("/")->assertRedirect(Filament::getUrl());
    }
}
