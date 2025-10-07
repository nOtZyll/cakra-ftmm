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
        Schema::create('item_rab', function (Blueprint $table) {
            $table->id('item_rab_id');
            $table->foreignId('pengajuan_id')->constrained('pengajuan', 'pengajuan_id')->onDelete('cascade');
            $table->string('nama_item', 255)->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('satuan', 50)->nullable();
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_rabs');
    }
};
