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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->smallInteger('order_type');
            $table->integer('order_totalPayment');
            $table->unsignedBigInteger('Member_member_id');
            $table->unsignedBigInteger('Voucher_voucher_id')->nullable();
            $table->integer('Employee_employee_id')->nullable();
            $table->integer('EventReservation_event_id')->nullable();
            $table->integer('Reservasi_reservasi_id')->nullable();
            $table->integer('PaymentMaster_payment_id')->nullable();
            $table->timestamps();

            $table->foreign('Member_member_id')->references('member_id')->on('members');
            $table->foreign('Voucher_voucher_id')->references('voucher_id')->on('vouchers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
