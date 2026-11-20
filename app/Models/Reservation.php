<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'dateReservation',
        'time',
        'price',
        'barbermans_id',
        'name',
        'phone',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function barberMan(): BelongsTo
    {
        return $this->belongsTo(BarberMan::class, 'barbermans_id', 'id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'reservationsservices', 'reservation_id', 'service_id');
    }

    public function getBarberShopAttribute()
    {
        return $this->barberMan?->barberShop;
    }
}
