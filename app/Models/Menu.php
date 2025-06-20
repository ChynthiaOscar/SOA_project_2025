<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'menu_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'menu_name',
        'menu_description',
        'menu_price',
        'menu_category',
        'menu_status',
    ];

    /**
     * Get the order items for this menu.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'menu_id', 'menu_id');
    }

    /**
     * Get the ratings for this menu.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'Menu_menu_id', 'menu_id');
    }

    /**
     * Get the average rating for this menu.
     */
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating');
    }
}
