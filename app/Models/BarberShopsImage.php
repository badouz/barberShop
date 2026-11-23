<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarberShopsImage extends Model
{
    protected $table = 'barbershopsimages';
    use HasFactory;
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
