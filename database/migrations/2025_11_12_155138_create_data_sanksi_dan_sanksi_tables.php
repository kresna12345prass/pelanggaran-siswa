<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 2. Tabel Data Sanksi (Hukuman yang ditetapkan)
        Schema::create('data_sanksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggaran_id')->constrained('pelanggaran')->onDelete('cascade');
            $table->foreignId('user_penetap')->nullable()->constrained('users')->onDelete('set null');

            $table->string('jenis_sanksi');
            $table->text('deskripsi_hukuman');
            
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            
            $table->enum('status_sanksi', ['pending', 'berjalan', 'selesai', 'terlambat'])->default('pending');
            $table->timestamps();
        });

        // 3. Tabel Pelaksanaan Sanksi (Log Harian/Bukti Selesai)
        Schema::create('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_sanksi_id')->constrained('data_sanksi')->onDelete('cascade');
            
            $table->date('tanggal_pelaksanaan');
            $table->string('bukti_foto')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['hadir', 'tidak_hadir', 'tuntas'])->default('hadir');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaksanaan_sanksi');
        Schema::dropIfExists('data_sanksi');
    }
};