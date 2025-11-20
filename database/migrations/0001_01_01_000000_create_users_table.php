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
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel guru (nullable, karena siswa/ortu/admin tidak punya data guru)
        // Pastikan migration 'guru' berjalan SEBELUM 'users' atau gunakan constraint nanti
        // Untuk aman, kita buat unsignedBigInteger dulu
        $table->unsignedBigInteger('guru_id')->nullable(); 
        
        $table->string('username')->unique();
        $table->string('nama_lengkap'); // Jika guru, ini diambil dari tabel guru nanti
        $table->string('email')->unique();
        $table->string('password');
        
        // Update Role Sesuai Dokumen
        $table->enum('level', [
            'admin', 
            'kesiswaan', 
            'guru', 
            'wali_kelas', 
            'bk', 
            'kepsek', 
            'siswa', 
            'ortu'
        ]);
        
        // Spesialisasi mungkin tidak perlu lagi karena sudah ada role spesifik, 
        // tapi kita simpan saja untuk jaga-jaga
        $table->string('spesialisasi')->nullable(); 
        $table->boolean('can_verify')->default(false);
        $table->rememberToken();
        $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
