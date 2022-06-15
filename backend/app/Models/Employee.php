<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary'
    ];

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class);
    }
}
