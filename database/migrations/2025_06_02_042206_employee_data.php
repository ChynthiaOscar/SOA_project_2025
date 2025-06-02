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
        Schema::create('employee_data', function (Blueprint $table) {
            $table->id(); // ID (auto-increment primary key)
            $table->string('nama'); // Nama
            $table->string('role'); // Role
            $table->string('email')->unique(); // Email
            $table->string('password'); // Password (harap di-hash)
            $table->decimal('salary_per_shift', 10, 2); // Gaji per shift
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_data');
    }
};
