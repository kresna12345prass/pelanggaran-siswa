<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggaran_id')->constrained('pelanggaran')->onDelete('cascade');
            
            // Relasi ke USERS (Kepala Sekolah)
            $table->foreignId('kepala_sekolah_id')->constrained('users')->onDelete('cascade');
            
            $table->string('status_monitoring', 100)->nullable();
            $table->text('catatan_monitoring')->nullable();
            $table->date('tanggal_monitoring')->nullable();
            $table->string('tindak_lanjut')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_pelanggaran');
    }
};