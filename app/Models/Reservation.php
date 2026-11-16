<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    protected $fillable = [
        'dateReservation',
        'time',
        'price',
        'barbermans_id',
        'name',
        'phone',
    ];

    public function barberMan(): BelongsTo
    {
        return $this->belongsTo(BarberMan::class, 'barbermans_id', 'id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'reservationsservices');
    }
}
