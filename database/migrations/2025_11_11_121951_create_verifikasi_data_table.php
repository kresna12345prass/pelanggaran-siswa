<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_data', function (Blueprint $table) {
            $table->id();
            $table->string('tabel_terkait');
            $table->unsignedBigInteger('id_terkait');
            
            $table->foreignId('user_pencatat')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_verifikator')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('status')->nullable(); // Revisi 5
            $table->text('catatan_verifikasi')->nullable();
            $table->dateTime('tanggal_pencatatan')->nullable();
            $table->dateTime('tanggal_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_data');
    }
};