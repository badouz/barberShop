<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicesImage extends Model
{
    use HasFactory;

    protected $table = 'servicesimages';

    protected $fillable = [
        'path',
        'is_primary',
        'service_id',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
