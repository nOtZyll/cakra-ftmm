<?php

namespace App\Http\Controllers\StafOrmawa;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Status;
use App\Models\HistoriStatus;
use Illuminate\Http\Request;
use App\Models\Lpj;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScreeningController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ormawaId = $user->ormawa_id;

        if (!$ormawaId) {
            return view('staf_ormawa.dashboard', [
                'daftarPengajuan' => collect(),
                'daftarLpj' => collect()
            ]);
        }

        $daftarPengajuan = Pengajuan::with(['user', 'status'])
            ->where('ormawa_id', $ormawaId)
            ->whereHas('status', function ($query) {
                $query->where('nama_status', 'Screening Ormawa');
            })
            ->orderBy('tanggal_pengajuan', 'asc')
            ->get();

        $daftarLpj = Lpj::with(['pengajuan.user'])
            ->whereHas('pengajuan', function ($query) use ($ormawaId) {
                $query->where('ormawa_id', $ormawaId);
            })
            ->where('status_lpj', 'Menunggu Screening Ormawa')
            ->get();

        return view('staf_ormawa.dashboard', compact('daftarPengajuan', 'daftarLpj'));
    }

    public function show(Pengajuan $pengajuan)
    {
        if ($pengajuan->ormawa_id !== Auth::user()->ormawa_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $pengajuan->load(['user', 'ormawa', 'status', 'itemsRab']);
        return view('staf_ormawa.screening.show', compact('pengajuan'));
    }

    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
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

        $namaStatusBaru = ($aksi == 'setujui') ? 'Verifikasi Fakultas' : 'Revisi';
        $status_baru = Status::where('nama_status', $namaStatusBaru)->first();

        if (!$status_baru) {
            return back()->with('error', 'Status tujuan tidak ditemukan. Hubungi admin.');
        }

        $pengajuan->current_status_id = $status_baru->status_id;
        $pengajuan->save();

        $histori = new HistoriStatus();
        $histori->pengajuan_id = $pengajuan->pengajuan_id;
        $histori->status_id = $status_baru->status_id;
        $histori->diubah_oleh_user_id = Auth::id();
        $histori->timestamp = Carbon::now();
        $histori->komentar = $komentar;
        $histori->save();

        return redirect()->route('staf_ormawa.dashboard')->with('success', 'Status pengajuan berhasil diperbarui.');
    }
    
    public function showLpj(Lpj $lpj)
    {
        $lpj->load(['pengajuan.itemsRab', 'itemsLpj']);
        return view('staf_ormawa.screening.lpj_show', [
            'lpj' => $lpj,
            'pengajuan' => $lpj->pengajuan
        ]);
    }

    public function updateLpjStatus(Request $request, Lpj $lpj)
    {
        $request->validate(['aksi' => 'required|in:setujui,revisi']);
        
        $aksi = $request->input('aksi');

        if ($aksi === 'setujui') {
            $lpj->status_lpj = 'Menunggu Verifikasi Fakultas';
            $pesan = 'LPJ berhasil disetujui dan diteruskan ke Staf Fakultas.';
        } else {
            $lpj->status_lpj = 'Perlu Revisi (Ormawa)';
            $lpj->komentar = $request->input('komentar');
            $pesan = 'LPJ telah dikembalikan ke mahasiswa untuk direvisi.';
        }

        $lpj->save();

        return redirect()->route('staf_ormawa.dashboard')->with('success', $pesan);
    }
}
