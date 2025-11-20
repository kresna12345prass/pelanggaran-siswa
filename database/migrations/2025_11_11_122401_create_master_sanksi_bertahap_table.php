<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_sanksi_bertahap', function (Blueprint $table) {
            $table->id();
            
            // Kategori Sanksi (Sesuai Pasal 11, 12, 13)
            $table->enum('kategori', ['RINGAN', 'SEDANG', 'BERAT']); 

            $table->string('nama_sanksi');
            $table->integer('poin_minimal');
            $table->integer('poin_maksimal');
            $table->text('deskripsi_tindakan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_sanksi_bertahap');
    }
};