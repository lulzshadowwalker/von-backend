<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, InteractsWithMedia;

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
        return Attribute::get(fn() => $this->getFirstMedia(self::MEDIA_COLLECTION_AVATAR));
    }
}
