<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'review_text',
        'Order_order_id',
        'Member_member_id',
    ];

    /**
     * Get the order that owns the review.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'Order_order_id', 'order_id');
    }    /**
     * Get the member who wrote the review.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'Member_member_id', 'member_id');
    }
}
