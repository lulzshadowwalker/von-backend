<?php

namespace App\Console\Commands;

use App\Enums\Role as RoleEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role as SpatieRole;

class UpsertAuthorization extends Command
{
    protected $signature = 'upsert:authorization';

    protected $description = 'Upsert roles and permissions';

    public function handle()
    {
        SpatieRole::findOrCreate(RoleEnum::PASSENGER->value, 'web');
        SpatieRole::findOrCreate(RoleEnum::DRIVER->value, 'web');
        SpatieRole::findOrCreate(RoleEnum::ADMIN->value, 'web');

        $this->info('Authorization roles and permissions upserted successfully.');
    }
}
