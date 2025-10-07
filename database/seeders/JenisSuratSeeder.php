<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisSurat::create(['nama_jenis' => 'Surat Permintaan Bantuan Dana (SPBD)']);
        JenisSurat::create(['nama_jenis' => 'Laporan Pertanggungjawaban (LPJ)']);
        JenisSurat::create(['nama_jenis' => 'Lainnya']);
    }
}
