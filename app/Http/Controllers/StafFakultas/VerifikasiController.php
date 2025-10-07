<?php

namespace App\Http\Controllers\StafFakultas;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk Staf Keuangan Fakultas.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil data pengajuan yang perlu verifikasi RAB (status: Verifikasi Fakultas)
        $antrianRab = Pengajuan::with(['user', 'ormawa'])
            ->whereHas('status', function ($query) {
                $query->where('nama_status', 'Verifikasi Fakultas');
            })
            ->orderBy('tanggal_pengajuan', 'asc')
            ->take(5) // Ambil 5 teratas untuk ditampilkan di dashboard
            ->get();

        // Ambil data pengajuan yang LPJ-nya perlu diverifikasi (status_lpj: Menunggu Verifikasi)
        $antrianLpj = Pengajuan::with(['user', 'ormawa'])
            ->whereHas('lpj', function ($query) {
                $query->where('status_lpj', 'Menunggu Verifikasi');
            })
            ->orderBy('updated_at', 'asc') // Berdasarkan kapan LPJ di-submit
            ->take(5)
            ->get();

        // Statistik Cepat
        $stats = [
            'menunggu_verifikasi' => $antrianRab->count() + $antrianLpj->count(),
            'total_ormawa' => \App\Models\Ormawa::count(),
            // Anda bisa menambahkan statistik lain di sini
        ];

        return view('staf_fakultas.dashboard', compact('user', 'antrianRab', 'antrianLpj', 'stats'));
    }
    /**
     * --- METHOD BARU: Menampilkan detail RAB untuk diverifikasi ---
     */
    public function showRab(Pengajuan $pengajuan)
    {
        // Load relasi yang dibutuhkan untuk halaman detail
        $pengajuan->load(['user', 'ormawa', 'status', 'itemsRab']);

        // Kirim data pengajuan ke view
        return view('staf_fakultas.verifikasi.rab_show', compact('pengajuan'));
    }
}