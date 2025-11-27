<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_kategori_sanksi', function (Blueprint $table) {
            $table->id();
            $table->string('kategori'); // Ringan, Sedang, Berat
            $table->string('pasal'); // Pasal 11, Pasal 12, Pasal 13
            $table->integer('poin_min');
            $table->integer('poin_max');
            $table->text('deskripsi_sanksi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kategori_sanksi');
    }
};
