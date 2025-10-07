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
        Schema::create('histori_status', function (Blueprint $table) {
            $table->id('histori_id');
            $table->foreignId('pengajuan_id')->constrained('pengajuan', 'pengajuan_id')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('status', 'status_id');
            $table->foreignId('diubah_oleh_user_id')->constrained('users', 'user_id');
            $table->datetime('timestamp')->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_statuses');
    }
};
