<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_name',
        'member_email',
        'member_phone',
    ];    /**
     * Get the orders for this member.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'Member_member_id', 'member_id');
    }
    
    /**
     * Get the reviews written by this member.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'Member_member_id', 'member_id');
    }
    
    /**
     * Get the ratings given by this member.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'Member_member_id', 'member_id');
    }
}
