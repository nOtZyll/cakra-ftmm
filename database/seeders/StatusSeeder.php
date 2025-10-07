<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['nama_status' => 'Draft', 'deskripsi' => 'Pengajuan masih dalam bentuk draft oleh mahasiswa.']);
        Status::create(['nama_status' => 'Screening Ormawa', 'deskripsi' => 'Pengajuan sedang diperiksa oleh Staf Keuangan Ormawa.']);
        Status::create(['nama_status' => 'Verifikasi Fakultas', 'deskripsi' => 'Pengajuan sedang diverifikasi oleh Staf Keuangan Fakultas.']);
        Status::create(['nama_status' => 'Revisi', 'deskripsi' => 'Pengajuan perlu direvisi oleh mahasiswa.']);
        Status::create(['nama_status' => 'Disetujui', 'deskripsi' => 'Pengajuan telah disetujui, menunggu pencairan dana.']);
        Status::create(['nama_status' => 'Dana Cair', 'deskripsi' => 'Dana telah dicairkan.']);
        Status::create(['nama_status' => 'Ditolak', 'deskripsi' => 'Pengajuan ditolak.']);
        Status::create(['nama_status' => 'Selesai', 'deskripsi' => 'Proses pengajuan dan LPJ telah selesai.']);
    }
}