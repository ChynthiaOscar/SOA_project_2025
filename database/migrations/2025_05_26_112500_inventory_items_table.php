<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->integer('inventoryItem_id')->primary();
            $table->string('inventoryItem_name');
            $table->string('inventoryItem_description');
            $table->double('inventoryItem_currentQuantity', 10, 2);
            $table->string('inventoryItem_unitOfMeasure');
            $table->double('inventoryItem_reorderPoint', 10, 2);
            $table->double('inventoryItem_initialStockLevel', 10, 2);
            $table->date('inventoryItem_lastUpdated');
            $table->integer('inventoryCategory_inventoryCategory_id');
            $table->timestamps();

            $table->foreign('inventoryCategory_inventoryCategory_id')
                ->references('inventoryCategory_id')
                ->on('inventory_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
