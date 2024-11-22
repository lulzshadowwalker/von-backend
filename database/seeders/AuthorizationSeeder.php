<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class AuthorizationSeeder extends Seeder
{
    public function run(): void
    {
        $failed = Artisan::call('upsert:authorization');

        if ($failed) {
            $this->command->error('Failed to seed authorization data');
            return;
        }
    }
}
