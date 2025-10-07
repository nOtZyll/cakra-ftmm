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
        Schema::create('template_dokumen', function (Blueprint $table) {
            $table->id('template_id');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat', 'jenis_surat_id');
            $table->string('nama_template', 100)->nullable();
            $table->string('link_template', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_dokumens');
    }
};
