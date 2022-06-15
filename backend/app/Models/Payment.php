<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'employee_id'
    ];

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class);
    }}
