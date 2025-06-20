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
    {        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->text('review_text');
            $table->unsignedBigInteger('Order_order_id');
            $table->unsignedBigInteger('Member_member_id');
            $table->timestamps();

            $table->foreign('Order_order_id')->references('order_id')->on('orders');
            $table->foreign('Member_member_id')->references('member_id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
