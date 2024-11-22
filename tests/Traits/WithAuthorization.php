<?php

namespace Tests\Traits;

trait WithAuthorization
{
    public function setUpWithAuthorization(): void
    {
        $this->artisan('upsert:authorization');
    }
}
