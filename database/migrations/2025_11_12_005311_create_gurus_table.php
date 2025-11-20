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
        Schema::create('guru', function (Blueprint $table) {
        $table->id();
        $table->string('nip', 30)->unique()->nullable();
        $table->string('nama_guru');
        $table->string('bidang_studi')->nullable(); // Mapel yang diajarkan
        $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
        $table->string('no_telepon', 20)->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
