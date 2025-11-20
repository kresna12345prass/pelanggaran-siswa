<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bimbingan_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            
            // Relasi ke USERS (Guru BK/Konselor)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('jenis_layanan')->nullable();
            $table->string('topik')->nullable();
            $table->text('keluhan_masalah')->nullable();
            $table->text('tindakan_solusi')->nullable();
            $table->string('status', 100)->nullable();
            $table->date('tanggal_konseling')->nullable();
            $table->date('tanggal_tindak_lanjut')->nullable(); // Revisi 1
            $table->text('hasil_evaluasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan_konseling');
    }
};