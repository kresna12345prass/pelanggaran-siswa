<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orangtua', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke USERS (akun ortu)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke SISWA (anaknya)
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            
            $table->string('hubungan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orangtua');
    }
};