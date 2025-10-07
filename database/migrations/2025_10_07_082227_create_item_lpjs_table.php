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
        Schema::create('item_lpj', function (Blueprint $table) {
            $table->id('item_lpj_id');
            $table->foreignId('lpj_id')->constrained('lpj', 'lpj_id')->onDelete('cascade');
            $table->string('nama_pengeluaran', 255)->nullable();
            $table->integer('jumlah_realisasi')->nullable();
            $table->string('satuan', 50)->nullable();
            $table->decimal('harga_realisasi', 15, 2)->nullable();
            $table->string('path_foto_nota', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_lpjs');
    }
};
