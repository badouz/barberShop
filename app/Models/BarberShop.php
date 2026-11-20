<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class BarberShop extends Model
    {
    protected $table="barbershops";

    protected $fillable = [
        'name',
        'address',
        'city',
        'zip',
        'latitude',
        'Longitude',
        'user_id',
    ];


    public function barberMen(): HasMany
    {
        return $this->hasMany(BarberMan::class, 'barbershop_id', 'id');
    }

    public function reservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, BarberMan::class, 'barbershop_id', 'barbermans_id', 'id', 'id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'barbershop_id', 'id');
    }

    public function barberShopImages(): HasMany
    {
        return $this->hasMany(BarberShopsImage::class, 'barbershop_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
