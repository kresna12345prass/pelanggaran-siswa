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
        Schema::table('data_sanksi', function (Blueprint $table) {
            $table->boolean('perlu_konseling')->default(false)->after('status_sanksi');
            $table->foreignId('bk_user_id')->nullable()->constrained('users')->onDelete('set null')->after('perlu_konseling');
            $table->text('catatan_bk')->nullable()->after('bk_user_id');
            $table->enum('status_konseling', ['belum', 'proses', 'selesai'])->default('belum')->after('catatan_bk');
        });

        Schema::table('bimbingan_konseling', function (Blueprint $table) {
            $table->foreignId('data_sanksi_id')->nullable()->constrained('data_sanksi')->onDelete('set null')->after('user_id');
            $table->enum('sumber_rujukan', ['mandiri', 'sanksi', 'guru', 'ortu', 'wali_kelas'])->default('mandiri')->after('data_sanksi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_sanksi', function (Blueprint $table) {
            $table->dropForeign(['bk_user_id']);
            $table->dropColumn(['perlu_konseling', 'bk_user_id', 'catatan_bk', 'status_konseling']);
        });

        Schema::table('bimbingan_konseling', function (Blueprint $table) {
            $table->dropForeign(['data_sanksi_id']);
            $table->dropColumn(['data_sanksi_id', 'sumber_rujukan']);
        });
    }
};
