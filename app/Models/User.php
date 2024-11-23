<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, InteractsWithMedia, HasRoles, HasApiTokens;

    const MEDIA_COLLECTION_AVATAR = 'avatar';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    public function passenger(): HasOne
    {
        return $this->hasOne(Passenger::class);
    }

    public function deviceTokens(): HasMany
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function registerMediaCollections(): void
    {
        $name = Str::replace(' ', '+', $this->name);

        $this->addMediaCollection(self::MEDIA_COLLECTION_AVATAR)
            ->useFallbackUrl("https://ui-avatars.com/api/?name={$name}")
            ->singleFile();
    }

    public function avatar(): Attribute
    {
        return Attribute::get(fn() => $this->getFirstMediaUrl(self::MEDIA_COLLECTION_AVATAR));
    }

    public function avatarFile(): Attribute
    {
        return Attribute::get(fn() => $this->getFirstMedia(self::MEDIA_COLLECTION_AVATAR));
    }

    public function scopePassengers(Builder $query): void
    {
        $query->role(Role::PASSENGER);
    }

    public function scopeDrivers(Builder $query): void
    {
        $query->role(Role::DRIVER);
    }

    public function scopeAdmins(Builder $query): void
    {
        $query->role(Role::ADMIN);
    }

    public function isPassenger(): Attribute
    {
        return Attribute::get(fn() => $this->hasRole(Role::PASSENGER));
    }

    public function isDriver(): Attribute
    {
        return Attribute::get(fn() => $this->hasRole(Role::DRIVER));
    }

    public function isAdmin(): Attribute
    {
        return Attribute::get(fn() => $this->hasRole(Role::ADMIN));
    }
}
