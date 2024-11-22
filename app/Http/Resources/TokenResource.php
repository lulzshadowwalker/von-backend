<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TokenResource extends JsonResource
{
    public function toArray(Object $data): array
    {
        return [
            'type' => 'auth-tokens',
            'id' => Str::uuid(),
            'attributes' => [
                'token' => $this->token(),
            ],
            'links' => (object) [],
            'relationships' => (object) [],
            'includes' => (object) [],
        ];
    }
}
