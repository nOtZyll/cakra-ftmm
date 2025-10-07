<?php

namespace Database\Seeders;

use App\Models\Ormawa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ormawa::create(['nama_ormawa' => 'HIMATESDA (Himpunan Mahasiswa Teknologi Sains Data)']);
        Ormawa::create(['nama_ormawa' => 'HIMATERA (Himpunan Mahasiswa Teknik Robotika dan Kecerdasan Buatan)']);
        Ormawa::create(['nama_ormawa' => 'HMTI (Himpunan Mahasiswa Teknik Industri)']);
        Ormawa::create(['nama_ormawa' => 'IME (Ikatan Mahasiswa Elektro)']);
        Ormawa::create(['nama_ormawa' => 'HIMANO (Himpunan Mahasiswa Rekayasa Nanoteknologi)']);
        Ormawa::create(['nama_ormawa' => 'BEM FTMM']);
        Ormawa::create(['nama_ormawa' => 'IRIS']);
        Ormawa::create(['nama_ormawa' => 'EV-OS']);
        Ormawa::create(['nama_ormawa' => 'KOMBO UNAIR']);
        Ormawa::create(['nama_ormawa' => 'RASENA']);
        Ormawa::create(['nama_ormawa' => 'IMERCY']);
    }
}
