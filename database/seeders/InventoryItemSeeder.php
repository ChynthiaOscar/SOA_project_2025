<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DB::table('inventory_categories')->pluck('inventoryCategory_id', 'inventoryCategory_name');
        DB::table('inventory_items')->insert([
            [
                'inventoryItem_id' => 1,
                'inventoryItem_name' => 'Ayam Fillet',
                'inventoryItem_description' => 'Daging ayam tanpa tulang, segar.',
                'inventoryItem_currentQuantity' => 50.5,
                'inventoryItem_unitOfMeasure' => 'kg',
                'inventoryItem_reorderPoint' => 10.0,
                'inventoryItem_initialStockLevel' => 60.0,
                'inventoryItem_lastUpdated' => '2025-05-23',
                'inventoryCategory_inventoryCategory_id' => $categories['Daging Ayam'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'inventoryItem_id' => 2,
                'inventoryItem_name' => 'Daging Sapi Slice',
                'inventoryItem_description' => 'Irisan daging sapi untuk shabu-shabu.',
                'inventoryItem_currentQuantity' => 30.0,
                'inventoryItem_unitOfMeasure' => 'kg',
                'inventoryItem_reorderPoint' => 5.0,
                'inventoryItem_initialStockLevel' => 40.0,
                'inventoryItem_lastUpdated' => '2025-05-23',
                'inventoryCategory_inventoryCategory_id' => $categories['Daging Sapi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'inventoryItem_id' => 3,
                'inventoryItem_name' => 'Daging Babi Cincang',
                'inventoryItem_description' => 'Daging babi cincang segar.',
                'inventoryItem_currentQuantity' => 20.0,
                'inventoryItem_unitOfMeasure' => 'kg',
                'inventoryItem_reorderPoint' => 5.0,
                'inventoryItem_initialStockLevel' => 25.0,
                'inventoryItem_lastUpdated' => '2025-05-23',
                'inventoryCategory_inventoryCategory_id' => $categories['Daging Babi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'inventoryItem_id' => 4,
                'inventoryItem_name' => 'Saus Tiram',
                'inventoryItem_description' => 'Saus tiram botolan.',
                'inventoryItem_currentQuantity' => 15.0,
                'inventoryItem_unitOfMeasure' => 'liter',
                'inventoryItem_reorderPoint' => 3.0,
                'inventoryItem_initialStockLevel' => 20.0,
                'inventoryItem_lastUpdated' => '2025-05-23',
                'inventoryCategory_inventoryCategory_id' => $categories['Saus'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'inventoryItem_id' => 5,
                'inventoryItem_name' => 'Telur Ayam',
                'inventoryItem_description' => 'Telur ayam segar.',
                'inventoryItem_currentQuantity' => 200.0,
                'inventoryItem_unitOfMeasure' => 'butir',
                'inventoryItem_reorderPoint' => 50.0,
                'inventoryItem_initialStockLevel' => 250.0,
                'inventoryItem_lastUpdated' => '2025-05-23',
                'inventoryCategory_inventoryCategory_id' => $categories['Telur'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'inventoryItem_id' => 6,
                'inventoryItem_name' => 'Bawang Putih',
                'inventoryItem_description' => 'Bumbu dapur utama.',
                'inventoryItem_currentQuantity' => 10.0,
                'inventoryItem_unitOfMeasure' => 'kg',
                'inventoryItem_reorderPoint' => 2.0,
                'inventoryItem_initialStockLevel' => 12.0,
                'inventoryItem_lastUpdated' => '2025-05-23',
                'inventoryCategory_inventoryCategory_id' => $categories['Bumbu'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'inventoryItem_id' => 7,
                'inventoryItem_name' => 'Bawang Merah',
                'inventoryItem_description' => 'Bumbu dapur utama.',
                'inventoryItem_currentQuantity' => 5.0,
                'inventoryItem_unitOfMeasure' => 'kg',
                'inventoryItem_reorderPoint' => 10.0,
                'inventoryItem_initialStockLevel' => 12.0,
                'inventoryItem_lastUpdated' => '2025-05-23',
                'inventoryCategory_inventoryCategory_id' => $categories['Bumbu'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
