<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $primaryKey = 'voucher_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'voucher_code',
        'voucher_description',
        'voucher_value',
        'voucher_type',
        'voucher_minimum_order',
        'voucher_usage_limit',
        'voucher_status',
    ];

    /**
     * Get the orders that used this voucher.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'Voucher_voucher_id', 'voucher_id');
    }
}
