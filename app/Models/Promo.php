<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'description',
        'promo_value',
        'value_type',
        'minimum_order',
        'usage_limit',
        'status'
    ];
}