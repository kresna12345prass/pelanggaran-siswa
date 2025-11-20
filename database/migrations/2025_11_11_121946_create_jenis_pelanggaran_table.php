<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel kategori di atas
        $table->foreignId('kategori_pelanggaran_id')->constrained('kategori_pelanggaran')->onDelete('cascade');
        
        // Level 3: Item Pelanggaran
        $table->string('nama_pelanggaran'); 
        $table->integer('poin');
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pelanggaran');
    }
};