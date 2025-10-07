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
use Illuminate\Support\Facades\DB;


class VerifikasiController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk Staf Keuangan Fakultas.
     */
    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $request->validate(['action' => 'required|in:setuju,revisi']);
        $action = $request->input('action');

        $newStatus = $action === 'setuju'
            ? Status::where('nama_status', 'Disetujui')->firstOrFail()
            : Status::where('nama_status', 'Revisi')->firstOrFail();

        $pengajuan->status()->associate($newStatus);
        $pengajuan->save();

        HistoriStatus::create([
            'pengajuan_id' => $pengajuan->pengajuan_id,
            'status_id' => $newStatus->status_id,
            'diubah_oleh_user_id' => Auth::id(),
        ]);

        return redirect()->route('staf_fakultas.dashboard')
            ->with('success', $action === 'setuju'
                ? 'Pengajuan telah disetujui.'
                : 'Pengajuan telah dikembalikan untuk revisi.');
    }
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
                $query->where('status_lpj', 'Menunggu Verifikasi Fakultas'); // ✅
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
    public function showLpj(Lpj $lpj)
    {
        $lpj->load(['pengajuan.user','pengajuan.ormawa','pengajuan.itemsRab','items']);
        return view('staf_fakultas.verifikasi.lpj_show', [
            'lpj' => $lpj,
            'pengajuan' => $lpj->pengajuan,
        ]);
    }

    /**
     * Memproses update status verifikasi RAB (Setuju/Revisi) tanpa komentar.
     */
    public function updateLpjStatus(Request $request, Lpj $lpj)
    {
        // Guard status: hanya boleh saat masih di antrian Fakultas
        if ($lpj->status_lpj !== 'Menunggu Verifikasi Fakultas') {
            return redirect()
                ->route('staf_fakultas.dashboard')
                ->with('warning', 'LPJ ini tidak sedang menunggu verifikasi fakultas.');
        }

        // Idempoten: kalau sudah disetujui, jangan apa-apa
        if ($lpj->status_lpj === 'Disetujui') {
            return redirect()
                ->route('staf_fakultas.dashboard')
                ->with('info', 'LPJ ini sudah disetujui sebelumnya.');
        }

        // Tidak ada opsi tolak lagi → validasi cukup setuju
        $request->validate([
            'action' => 'required|in:setuju',
        ]);

        DB::transaction(function () use ($lpj) {
            // 1) LPJ final → Disetujui
            $lpj->status_lpj = 'Disetujui';
            $lpj->komentar   = null;
            $lpj->save();

            // 2) Pengajuan → Selesai
            $statusSelesai = Status::where('nama_status', 'Selesai')->firstOrFail();

            if (method_exists($lpj->pengajuan, 'status')) {
                $lpj->pengajuan->status()->associate($statusSelesai);
            } else {
                // kalau skemamu pakai kolom FK eksplisit
                $lpj->pengajuan->current_status_id = $statusSelesai->status_id;
            }
            $lpj->pengajuan->save();

            // 3) Histori status (Selesai)
            HistoriStatus::create([
                'pengajuan_id'        => $lpj->pengajuan_id,
                'status_id'           => $statusSelesai->status_id,
                'diubah_oleh_user_id' => Auth::id(),
                'komentar'            => 'LPJ disetujui oleh Staf Fakultas; pengajuan dinyatakan selesai.',
            ]);
        });

        return redirect()
            ->route('staf_fakultas.dashboard')
            ->with('success', 'LPJ disetujui dan Pengajuan dinyatakan Selesai.');
    }

}