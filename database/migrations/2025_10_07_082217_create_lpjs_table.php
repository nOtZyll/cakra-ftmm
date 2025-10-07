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
        Schema::create('lpj', function (Blueprint $table) {
            $table->id('lpj_id');
            $table->foreignId('pengajuan_id')->unique()->constrained('pengajuan', 'pengajuan_id'); // Relasi One-to-One
            $table->datetime('tanggal_lapor')->nullable();
            $table->decimal('total_realisasi', 15, 2)->nullable();
            $table->string('status_lpj', 50)->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpjs');
    }
};
