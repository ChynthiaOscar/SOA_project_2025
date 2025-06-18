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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
            $table->foreignId('slot_time_id')->constrained()->onDelete('cascade');
            $table->date('reservation_date');
            $table->json('slot_time'); // Misalnya: ["13:00 - 14:30", "15:00 - 16:30"]
            $table->integer('table_count');
            $table->json('table_numbers')->nullable(); // Misal: [7, 8]
            $table->decimal('dp_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'cancelled'])->default('pending');
            $table->timestamp('payment_time')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
