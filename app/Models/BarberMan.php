<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarberMan extends Model
{
    protected $fillable = [
        'name',
        'barbershop_id',
    ];

    public function barberShop(): BelongsTo
    {
        return $this->belongsTo(BarberShop::class, 'barbershop_id', 'id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'barbermans_id', 'id');
    }
}
