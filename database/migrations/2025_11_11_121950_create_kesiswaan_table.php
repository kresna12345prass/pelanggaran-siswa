<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // REVISI 2: Nama tabel diubah menjadi KESISWAAN
    public function up(): void
    {
        Schema::create('kesiswaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            
            $table->string('status', 100)->nullable(); // Misal: Aktif, Lulus, Pindah
            $table->date('tanggal_daftar')->nullable();
            $table->string('jam_masuk', 50)->nullable(); // Sesuai ERD
            $table->string('no_ijazah', 100)->nullable();
            $table->string('catatan_khusus')->nullable();
            
            // Relasi ke USERS (Pencatat & Verifikator)
            $table->foreignId('user_pencatat')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_verifikator')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('status_verifikasi', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kesiswaan');
    }
};