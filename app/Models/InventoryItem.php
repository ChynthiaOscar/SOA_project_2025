<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $primaryKey = 'inventoryItem_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'inventoryItem_id',
        'inventoryItem_name',
        'inventoryItem_description',
        'inventoryItem_currentQuantity',
        'inventoryItem_unitOfMeasure',
        'inventoryItem_reorderPoint',
        'inventoryItem_initialStockLevel',
        'inventoryItem_lastUpdated',
        'inventoryCategory_inventoryCategory_id',
    ];

    public function category()
    {
        return $this->belongsTo(
            InventoryCategory::class,
            'inventoryCategory_inventoryCategory_id', 
            'inventoryCategory_id' 
        );
    }
}
