<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('jenis_prestasi_id')->constrained('jenis_prestasi')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            
            $table->integer('poin')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('tingkat')->nullable(); // Revisi 3
            $table->string('penghargaan')->nullable();
            
            // Relasi ke USERS (Pencatat & Verifikator)
            $table->foreignId('user_pencatat')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_verifikator')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('status_verifikasi', 100)->nullable();
            $table->text('catatan_verifikasi')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};