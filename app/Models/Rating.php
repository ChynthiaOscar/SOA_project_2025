<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $primaryKey = 'rating_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'rating',
        'Menu_menu_id',
        'Order_order_id',
        'Member_member_id',
    ];

    /**
     * Get the menu that was rated.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'Menu_menu_id', 'menu_id');
    }

    /**
     * Get the order that the rating belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'Order_order_id', 'order_id');
    }    /**
     * Get the member who gave the rating.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'Member_member_id', 'member_id');
    }
}
