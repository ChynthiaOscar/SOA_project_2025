<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventory_categories')->insert([
            [
                'inventoryCategory_id' => 1,
                'inventoryCategory_name' => 'Daging Ayam',
                'inventoryCategory_description' => 'Semua produk daging ayam segar dan olahan.'
            ],
            [
                'inventoryCategory_id' => 2,
                'inventoryCategory_name' => 'Daging Sapi',
                'inventoryCategory_description' => 'Semua produk daging sapi segar dan olahan.'
            ],
            [
                'inventoryCategory_id' => 3,
                'inventoryCategory_name' => 'Daging Babi',
                'inventoryCategory_description' => 'Semua produk daging babi segar dan olahan.'
            ],
            [
                'inventoryCategory_id' => 4,
                'inventoryCategory_name' => 'Saus',
                'inventoryCategory_description' => 'Berbagai macam saus untuk masakan.'
            ],
            [
                'inventoryCategory_id' => 5,
                'inventoryCategory_name' => 'Telur',
                'inventoryCategory_description' => 'Telur ayam, bebek, dan lainnya.'
            ],
            [
                'inventoryCategory_id' => 6,
                'inventoryCategory_name' => 'Bumbu',
                'inventoryCategory_description' => 'Bumbu dapur dan rempah-rempah.'
            ],
        ]);
    }
}
