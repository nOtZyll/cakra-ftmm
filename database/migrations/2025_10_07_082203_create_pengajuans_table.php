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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id('pengajuan_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('ormawa_id')->nullable()->constrained('ormawa', 'ormawa_id');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat', 'jenis_surat_id');
            $table->string('judul_kegiatan', 255)->nullable();
            $table->string('link_dokumen', 255)->nullable();
            $table->datetime('tanggal_pengajuan')->nullable();
            $table->decimal('total_rab', 15, 2)->nullable();
            $table->foreignId('current_status_id')->constrained('status', 'status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
