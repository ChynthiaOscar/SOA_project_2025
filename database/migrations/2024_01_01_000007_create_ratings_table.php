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
    {        Schema::create('ratings', function (Blueprint $table) {
            $table->id('rating_id');
            $table->integer('rating');
            $table->unsignedBigInteger('Menu_menu_id');
            $table->unsignedBigInteger('Order_order_id');
            $table->unsignedBigInteger('Member_member_id');
            $table->timestamps();

            $table->foreign('Menu_menu_id')->references('menu_id')->on('menus');
            $table->foreign('Order_order_id')->references('order_id')->on('orders');
            $table->foreign('Member_member_id')->references('member_id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
