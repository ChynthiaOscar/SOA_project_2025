<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('no_hp');
            $table->string('password');
            $table->boolean('status')->default(0); // 0 = belum aktif, 1 = ulang tahun
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('members');
    }
};

