<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel ini untuk menyimpan konten Pasal 6 & 7
     * agar bisa di-CRUD oleh Admin.
     */
    public function up(): void
    {
        Schema::create('master_tata_tertib', function (Blueprint $table) {
            $table->id();
            
            // Misal: "Pasal 6" atau "Pasal 7"
            $table->string('pasal'); 
            
            // Misal: "KEWAJIBAN" atau "LARANGAN"
            $table->string('judul'); 

            // Untuk struktur data: 
            // 'induk' = Teks pembuka
            // 'poin' = Poin bernomor (1, 2, 3)
            // 'subpoin' = Poin berhuruf (a, b, c)
            $table->enum('tipe', ['induk', 'poin', 'subpoin']);
            
            // Menyimpan teks dari PDF
            $table->text('konten_teks'); 
            
            // Untuk mengurutkan poin 1, 2, 3...
            $table->integer('urutan'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_tata_tertib');
    }
};