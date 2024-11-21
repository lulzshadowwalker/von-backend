<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate',
        'capacity',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class);
    }

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class);
    }
}
