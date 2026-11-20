<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ADMIN="ADMIN";
    public const BARBER_SHOP="BARBERSHOP";
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'city',
        'address',
        'zip',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     public function barberShops(): HasMany
    {
        return $this->hasMany(BarberShop::class, 'user_id', 'id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'user_id', 'id');
    }

    public function isAdmin(): bool
    {
        return strtoupper((string) $this->role) === self::ADMIN;
    }

    public function isBarberShop(): bool
    {
        return strtoupper((string) $this->role) === self::BARBER_SHOP;
    }

    public function barberShopIds(): array
    {
        return $this->barberShops()->pluck('id')->toArray();
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
