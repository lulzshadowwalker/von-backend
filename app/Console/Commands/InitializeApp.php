<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitializeApp extends Command
{
    protected $signature = 'app:init';

    protected $description = 'Initialize the application';

    public function handle()
    {
        $this->info('Initializing application for production...');

        Artisan::call('upsert:authorization');
        $this->info('Authorization roles and permissions upserted successfully.');

        $this->info('⏺ Application initialized successfully.');
    }
}
