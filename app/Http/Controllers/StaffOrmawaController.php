<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Per 1: Impor Model Pengajuan agar kita bisa bicara dengan tabel 'pengajuan'
use App\Models\Pengajuan;
// Per 2: Impor Fassad Auth agar kita bisa tahu siapa user yang sedang login
use Illuminate\Support\Facades\Auth;

class StaffOrmawaController extends Controller
{
    /**
     * Metode ini akan dipanggil oleh rute /dashboard.
     * Tugasnya adalah mengambil semua pengajuan untuk ormawa staff tersebut
     * dan menampilkannya di halaman dashboard.
     */
    public function index()
    {
        // Langkah 1: Dapatkan informasi lengkap user yang sedang login.
        $user = Auth::user();

        // Langkah 2: Lakukan pengecekan keamanan. Jika tidak ada user yang login
        // atau jika user tersebut tidak terdaftar di ormawa manapun, jangan lanjutkan.
        if (!$user || !$user->ormawa_id) {
            // Arahkan kembali ke halaman login dengan pesan error.
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Langkah 3: Ambil data pengajuan dari database.
        $daftarPengajuan = Pengajuan::where('ormawa_id', $user->ormawa_id) // Filter: Hanya pengajuan dari ormawa user ini
                                    ->with(['status', 'user', 'ormawa'])   // Eager Loading: Ambil juga data relasinya (status, user, ormawa) agar efisien
                                    ->orderBy('tanggal_pengajuan', 'desc') // Urutkan hasilnya berdasarkan tanggal, dari yang paling baru
                                    ->get(); // Eksekusi query dan ambil hasilnya

        // Langkah 4: Kirim data yang sudah didapat ke file view.
        // Nama 'daftarPengajuan' akan menjadi variabel yang bisa dipakai di file Blade.
        return view('staf_ormawa.dashboard', ['daftarPengajuan' => $daftarPengajuan]);
    }

    /**
     * Metode ini akan dipanggil oleh rute /screening/{id}.
     * Tugasnya adalah mengambil SATU detail pengajuan berdasarkan ID-nya
     * dan menampilkannya di halaman screening.
     */
    public function show($id)
    {
        // Dapatkan informasi user yang sedang login untuk validasi
        $user = Auth::user();

        // Cari pengajuan berdasarkan ID yang diberikan di URL.
        // Pastikan juga pengajuan itu milik ormawa dari user yang login.
        $pengajuan = Pengajuan::where('pengajuan_id', $id)
                             ->where('ormawa_id', $user->ormawa_id)
                             ->with(['status', 'user', 'ormawa', 'itemsRab']) // Ambil semua relasi yang mungkin dibutuhkan di halaman detail
                             ->firstOrFail(); // Ambil data pertama, atau tampilkan error 404 jika tidak ditemukan.

        // Kirim satu data pengajuan tersebut ke view 'show.blade.php'
        return view('staf_ormawa.screening.show', ['pengajuan' => $pengajuan]);
    }
}
