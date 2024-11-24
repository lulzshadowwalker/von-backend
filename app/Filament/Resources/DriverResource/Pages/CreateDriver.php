<?php

namespace App\Filament\Resources\DriverResource\Pages;

use App\Filament\Resources\DriverResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDriver extends CreateRecord
{
    protected static string $resource = DriverResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $user = User::create(
            array_merge(
                $this->data['user'],
                ['password' => 'password']
            )
        );

        return $user->driver()->create();
    }
}
