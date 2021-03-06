<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'photo_url',
        'description',
        'days',
        'hours',
        'price'
    ];

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class);
    }
}
