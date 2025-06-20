<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'order_type',
        'order_totalPayment',
        'Member_member_id',
        'Voucher_voucher_id',
        'Employee_employee_id',
        'EventReservation_event_id',
        'Reservasi_reservasi_id',
        'PaymentMaster_payment_id',
    ];

    /**
     * Get the member that owns the order.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'Member_member_id', 'member_id');
    }

    /**
     * Get the voucher that was used for the order.
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'Voucher_voucher_id', 'voucher_id');
    }

    /**
     * Get the order items for this order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    /**
     * Get the review for this order.
     */
    public function review()
    {
        return $this->hasOne(Review::class, 'Order_order_id', 'order_id');
    }

    /**
     * Get the ratings for this order.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'Order_order_id', 'order_id');
    }
}
