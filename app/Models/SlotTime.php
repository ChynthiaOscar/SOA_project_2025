<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlotTime extends Model
{
    protected $fillable = ['start_time', 'end_time', 'date'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
