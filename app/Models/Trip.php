<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'departured_at',
        'arrived_at',
        'driver_id',
        'bus_id',
        'route_id',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'departured_at' => 'datetime',
            'arrived_at' => 'datetime',
            'driver_id' => 'integer',
            'bus_id' => 'integer',
            'route_id' => 'integer',
        ];
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function passengers(): BelongsToMany
    {
        return $this->belongsToMany(Passenger::class);
    }
}
