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
            Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100);
            $table->integer('promo_value');
            $table->enum('value_type', ['fixed', 'percentage']);
            $table->integer('minimum_order')->default(0);
            $table->integer('usage_limit')->default(0);
            $table->integer('usage')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
