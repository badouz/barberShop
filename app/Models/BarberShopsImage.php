<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarberShopsImage extends Model
{
    protected $fillable = [
        'path',
        'is_primary',
        'barbershop_id',
    ];

    public function barberShop(): BelongsTo
    {
        return $this->belongsTo(BarberShop::class, 'barbershop_id', 'id');
    }
}
