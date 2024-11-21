<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'from_location_latitude',
        'from_location_longitude',
        'to_location_latitude',
        'to_location_longitude',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'from_location_latitude' => 'decimal:7',
            'from_location_longitude' => 'decimal:7',
            'to_location_latitude' => 'decimal:7',
            'to_location_longitude' => 'decimal:7',
        ];
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
