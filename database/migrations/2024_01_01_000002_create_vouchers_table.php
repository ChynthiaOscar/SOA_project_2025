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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('voucher_id');
            $table->string('voucher_code', 50)->unique();
            $table->string('voucher_description', 255);
            $table->integer('voucher_value');
            $table->string('voucher_type', 20);
            $table->integer('voucher_minimum_order');
            $table->integer('voucher_usage_limit');
            $table->string('voucher_status', 1)->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
