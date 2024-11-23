<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassengerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'passengers',
            'id' => (string) $this->id,
            'attributes' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'avatar' => $this->user->avatar,
            ],
            'links' => (object) [],
            'relationships' => (object) [],
            'includes' => (object) [],
            'meta' => (object) [],
        ];
    }
}
