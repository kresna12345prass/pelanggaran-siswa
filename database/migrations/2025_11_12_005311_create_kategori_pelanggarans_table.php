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
        Schema::create('kategori_pelanggaran', function (Blueprint $table) {
        $table->id();
        
        // Level 2: Contoh "KETERTIBAN", "ROKOK", "PAKAIAN"
        $table->string('nama_kategori'); 
        
        // Level 2: Kode Huruf (A, B, C...) sesuai dokumen
        $table->string('kode_kategori')->nullable(); 

        // Level 1: Contoh "KEPRIBADIAN", "KERAJINAN", "KERAPIAN"
        // Kita pakai ENUM saja karena pilihannya sudah pasti 3 itu
        $table->enum('kategori_induk', ['KEPRIBADIAN', 'KERAJINAN', 'KERAPIAN']);
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_pelanggarans');
    }
};
