<?php

namespace App\Http\Controllers\StafFakultas;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Status;
use App\Models\HistoriStatus;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            ->take(5)
            ->get();

        // Ambil data pengajuan yang LPJ-nya perlu diverifikasi (status_lpj: Menunggu Verifikasi)
        $antrianLpj = Pengajuan::with(['user', 'ormawa', 'lpj']) // Pastikan relasi lpj di-load
            ->whereHas('lpj', function ($query) {
                $query->where('status_lpj', 'Menunggu Verifikasi');
            })
            ->orderBy('updated_at', 'asc')
            ->take(5)
            ->get();

        // Statistik Cepat
        $stats = [
            'menunggu_verifikasi' => $antrianRab->count() + $antrianLpj->count(),
            'total_ormawa' => \App\Models\Ormawa::count(),
        ];

        return view('staf_fakultas.dashboard', compact('user', 'antrianRab', 'antrianLpj', 'stats'));
    }

    /**
     * Menampilkan detail RAB untuk diverifikasi.
     */
    public function showRab(Pengajuan $pengajuan)
    {
        $pengajuan->load(['user', 'ormawa', 'status', 'itemsRab']);
        return view('staf_fakultas.verifikasi.rab_show', compact('pengajuan'));
    }

    /**
     * Memproses update status verifikasi RAB (Setuju/Revisi) tanpa komentar.
     */
    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $request->validate(['action' => 'required|in:setuju,revisi']);
        $action = $request->input('action');

        if ($action === 'setuju') {
            $newStatus = Status::where('nama_status', 'Disetujui')->firstOrFail();
            $pesan = 'Pengajuan telah disetujui.';
        } else { // 'revisi'
            $newStatus = Status::where('nama_status', 'Revisi')->firstOrFail();
            $pesan = 'Pengajuan telah dikembalikan untuk revisi.';
        }

        $pengajuan->status()->associate($newStatus);
        $pengajuan->save();

        HistoriStatus::create([
            'pengajuan_id' => $pengajuan->pengajuan_id,
            'status_id' => $newStatus->status_id,
            'diubah_oleh_user_id' => Auth::id(),
        ]);

        return redirect()->route('staf_fakultas.dashboard')->with('success', $pesan);
    }

    /**
     * Menampilkan halaman detail untuk verifikasi LPJ.
     */
    public function showLpj(Lpj $lpj)
    {
        $lpj->load(['pengajuan.user', 'pengajuan.ormawa', 'pengajuan.itemsRab', 'itemsLpj']);
        return view('staf_fakultas.verifikasi.lpj_show', [
            'lpj' => $lpj,
            'pengajuan' => $lpj->pengajuan
        ]);
    }

    /**
     * Memproses dan memperbarui status LPJ (Setuju/Tolak) tanpa komentar.
     */
    public function updateLpjStatus(Request $request, Lpj $lpj)
    {
        // Validasi diubah menjadi 'setuju' atau 'tolak'
        $request->validate([
            'action' => 'required|in:setuju,tolak',
        ]);

        $action = $request->input('action');

        if ($action === 'setuju') {
            $lpj->status_lpj = 'Disetujui';
            $pesan = 'LPJ telah berhasil disetujui.';
        } else { // 'tolak'
            $lpj->status_lpj = 'Ditolak'; // Status diubah menjadi 'Ditolak'
            $pesan = 'LPJ telah ditolak.';
        }
        
        $lpj->save();

        // Membuat catatan histori (disesuaikan untuk 'Ditolak')
        $namaStatusHistori = ($action === 'setuju') ? 'LPJ Disetujui' : 'LPJ Ditolak';
        $statusUntukHistori = Status::where('nama_status', $namaStatusHistori)->first();

        if ($statusUntukHistori) {
            HistoriStatus::create([
                'pengajuan_id' => $lpj->pengajuan_id,
                'status_id' => $statusUntukHistori->status_id,
                'diubah_oleh_user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('staf_fakultas.dashboard')->with('success', $pesan);
    }
}