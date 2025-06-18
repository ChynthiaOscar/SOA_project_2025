<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['number', 'seat_count', 'is_available'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
