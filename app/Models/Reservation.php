<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'slot_time_id',
        'reservation_date',
        'slot_time',
        'table_count',
        'table_numbers',
        'dp_amount',
        'status',
        'payment_time',
        'payment_method',
        'note',
    ];

    protected $casts = [
        'slot_time' => 'array',
        'table_numbers' => 'array',
        'reservation_date' => 'date',
        'payment_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function slotTime()
    {
        return $this->belongsTo(SlotTime::class);
    }
}
