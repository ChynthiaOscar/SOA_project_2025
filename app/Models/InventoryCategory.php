<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    protected $primaryKey = 'inventoryCategory_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $fillable = [
        'inventoryCategory_id',
        'inventoryCategory_name',
        'inventoryCategory_description',
    ];

    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'inventoryCategory_inventoryCategory_id', 'inventoryCategory_id');
    }
}
