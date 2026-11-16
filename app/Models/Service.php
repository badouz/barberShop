<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'barbershop_id',
    ];

    protected $casts = [
        'price' => 'float',
        'duration' => 'integer',
    ];

    public function barberShop(): BelongsTo
    {
        return $this->belongsTo(BarberShop::class, 'barbershop_id', 'id');
    }

    public function serviceImages(): HasMany
    {
        return $this->hasMany(ServicesImage::class, 'service_id', 'id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ServicesImage::class, 'service_id', 'id')->where('is_primary', true);
    }

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservationsservices', 'service_id', 'reservation_id');
    }
}
