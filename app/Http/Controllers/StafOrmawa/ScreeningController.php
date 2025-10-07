<?php

namespace App\Http\Controllers\StafOrmawa;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Status;
use App\Models\HistoriStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScreeningController extends Controller
{
    /**
     * Menampilkan dashboard/halaman daftar pengajuan untuk di-screening.
     */
    public function index()
    {
        $user = Auth::user();
        $ormawaId = $user->ormawa_id;

        if (!$ormawaId) {
            return view('staf_ormawa.dashboard', ['pengajuans' => collect()]);
        }

        // Ambil data pengajuan dari ormawa yang sama dengan status 'Screening Ormawa'
        $daftarPengajuan = Pengajuan::with(['user', 'status'])
            ->where('ormawa_id', $ormawaId)
            ->whereHas('status', function ($query) {
                $query->where('nama_status', 'Screening Ormawa');
            })
            ->orderBy('tanggal_pengajuan', 'asc')
            ->paginate(10);

        return view('staf_ormawa.dashboard', compact('daftarPengajuan'));
    }

    /**
     * Menampilkan detail satu pengajuan untuk di-screening.
     */
    public function show(Pengajuan $pengajuan)
    {
        // Proteksi: Pastikan hanya bisa melihat pengajuan dari ormawanya sendiri.
        if ($pengajuan->ormawa_id !== Auth::user()->ormawa_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $pengajuan->load(['user', 'ormawa', 'status', 'itemsRab']);
        return view('staf_ormawa.screening.show', compact('pengajuan'));
    }

    /**
     * Mengupdate status pengajuan (Setuju atau Revisi).
     */
    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        // Proteksi: Pastikan hanya bisa memproses pengajuan dari ormawa sendiri
        if ($pengajuan->ormawa_id !== Auth::user()->ormawa_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $request->validate([
            'aksi' => 'required|in:setujui,revisi',
            'komentar' => 'nullable|string',
        ]);

        $aksi = $request->input('aksi');
        $komentar = $request->input('komentar');

        if ($aksi == 'revisi' && empty($komentar)) {
            return back()->with('error', 'Komentar wajib diisi jika meminta revisi.');
        }

        // Tentukan status baru berdasarkan aksi
        $namaStatusBaru = ($aksi == 'setujui') ? 'Verifikasi Fakultas' : 'Revisi';
        $status_baru = Status::where('nama_status', $namaStatusBaru)->first();

        if (!$status_baru) {
            return back()->with('error', 'Status tujuan tidak ditemukan. Hubungi admin.');
        }

        // Update status di tabel pengajuan
        $pengajuan->current_status_id = $status_baru->status_id;
        $pengajuan->save();

        // Catat di histori status
        $histori = new HistoriStatus();
        $histori->pengajuan_id = $pengajuan->pengajuan_id;
        $histori->status_id = $status_baru->status_id;
        $histori->diubah_oleh_user_id = Auth::id();
        $histori->timestamp = Carbon::now();
        $histori->komentar = $komentar;
        $histori->save();

        return redirect()->route('staf_ormawa.dashboard')->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}