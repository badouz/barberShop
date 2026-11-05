<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'barbershop_id',
    ];

    public function barberShop(): BelongsTo
    {
        return $this->belongsTo(BarberShop::class, 'barbershop_id', 'id');
    }

    public function serviceImages(): HasMany
    {
        return $this->hasMany(ServicesImage::class, 'service_id', 'id');
    }

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservationsservices');
    }
}
