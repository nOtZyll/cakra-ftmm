<?php

namespace Database\Seeders;

use App\Models\TemplateDokumen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateDokumenSeeder extends Seeder
{
    public function run(): void
    {
        TemplateDokumen::create([
            'jenis_surat_id' => 1,
            'nama_template' => 'Template Surat Permintaan Bantuan Dana (SPBD)',
            'link_template' => '[Link Template Surat Permintaan Bantuan Dana (SPBD)](https://docs.google.com/document/u/7/d/1GGaQ6opKSlitqdHZJO0UeOlRGJau-aQdV9-zXYh6gz8/mobilebasic)'
        ]);

        TemplateDokumen::create([
            'jenis_surat_id' => 2,
            'nama_template' => 'Template Laporan Pertanggungjawaban (LPJ)',
            'link_template' => '[Link Template Laporan Pertanggungjawaban (LPJ)](https://docs.google.com/document/d/1-0eWEDcA2MnOxXI9Qgo6nWC-n6IoXwqwFuNPD1jntk4/edit?usp=drive_link)'
        ]);
    }
}
