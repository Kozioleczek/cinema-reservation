<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'movie_id',
        'payment_id',
        'day',
        'hour',
        'seat'
    ];

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function movie(): HasOne
    {
        return $this->hasOne(Movie::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
