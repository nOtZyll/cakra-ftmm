<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            $table->string('link_gdocs', 2048)->nullable()->after('komentar');
        });
    }

    public function down(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            $table->dropColumn('link_gdocs');
        });
    }
};

