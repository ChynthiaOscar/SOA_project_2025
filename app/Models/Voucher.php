<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'promo_code',
        'description',
        'promo_value',
        'status'
    ];
}