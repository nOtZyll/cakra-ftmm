<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Lpj;
use App\Models\ItemLpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LpjController extends Controller
{
        /**
     * Memproses dan memperbarui status LPJ (Disetujui / Perlu Revisi).
     * (VERSI PERBAIKAN DENGAN HISTORI)
     */
    public function updateLpjStatus(Request $request, Lpj $lpj)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:setuju,revisi',
            'komentar' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $action = $request->input('action');
        $komentar = $request->input('komentar');

        if ($action === 'setuju') {
            $lpj->status_lpj = 'Disetujui';
            $pesan = 'LPJ telah berhasil disetujui.';
        } else { // 'revisi'
            if (empty($komentar)) {
                return back()->withErrors(['komentar' => 'Komentar wajib diisi untuk meminta revisi.'])->withInput();
            }
            $lpj->status_lpj = 'Perlu Revisi';
            $lpj->komentar = $komentar;
            $pesan = 'LPJ telah dikembalikan untuk revisi.';
        }
        
        $lpj->save();

        // ==================================================================
        // ==> TAMBAHKAN BLOK INI UNTUK MENYIMPAN HISTORI <==
        // Logika ini akan mencari status yang sesuai di tabel 'statuses'
        // dan membuat catatan di 'histori_status'
        
        $namaStatusHistori = ($action === 'setuju') ? 'LPJ Disetujui' : 'LPJ Revisi';
        $statusUntukHistori = \App\Models\Status::where('nama_status', $namaStatusHistori)->first();

        if ($statusUntukHistori) {
            \App\Models\HistoriStatus::create([
                'pengajuan_id' => $lpj->pengajuan_id, // Menggunakan ID dari pengajuan terkait
                'status_id' => $statusUntukHistori->status_id,
                'diubah_oleh_user_id' => \Illuminate\Support\Facades\Auth::id(),
                'komentar' => $komentar, // Komentar akan disimpan di sini
            ]);
        }
        // ==================================================================

        return redirect()->route('staf_fakultas.dashboard')->with('success', $pesan);
    }
   /**
     * Menampilkan daftar pengajuan yang siap untuk dilaporkan (dibuatkan LPJ).
     * (VERSI PERBAIKAN)
     */
    public function index()
    {
        $pengajuans = Pengajuan::where('user_id', Auth::id())
            // GUNAKAN whereHas untuk memfilter melalui relasi 'status'
            ->whereHas('status', function ($query) {
                // Filter berdasarkan nama status di tabel status
                $query->whereIn('nama_status', ['Disetujui', 'Dana Cair']);
            })
            ->whereDoesntHave('lpj') // Hanya tampilkan yang belum ada LPJ
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();
            
        return view('mahasiswa.lpj.index', compact('pengajuans'));
    }

    /**
     * Menampilkan form untuk membuat LPJ baru.
     * Laravel akan otomatis mencari Pengajuan berdasarkan {pengajuan} dari URL (Route Model Binding).
     */
    public function create(Pengajuan $pengajuan)
    {
        // Pastikan user yang mengakses adalah pemilik pengajuan
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        if ($pengajuan->lpj) {
            return redirect()->route('mahasiswa.lpj.index')
                         ->with('warning', 'LPJ untuk kegiatan ini sudah pernah dibuat.');
    }
        
        // Kirim data pengajuan ke view create.blade.php
        return view('mahasiswa.lpj.create', compact('pengajuan'));
    }

    /**
     * Menyimpan data LPJ yang baru disubmit.
     */
    public function store(Request $request, Pengajuan $pengajuan)
    {
        // 1. Validasi Input Form
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.harga_satuan' => 'required|numeric|min:0',
            'items.*.nota' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ==================================================================
        // ==> PASTIKAN BLOK KODE INI ADA DI CONTROLLER ANDA <==
        // 2. Hitung total realisasi dari input
        $totalRealisasi = 0; // Variabel didefinisikan di sini
        foreach ($request->items as $item) {
            // Nilainya dihitung dan ditambahkan di dalam loop ini
            $totalRealisasi += $item['jumlah'] * $item['harga_satuan'];
        }
        // ==================================================================

        // 3. Validasi tambahan: Total realisasi tidak boleh melebihi RAB
        if ($totalRealisasi > $pengajuan->total_rab) {
            return back()->withErrors(['total_realisasi' => 'Total realisasi tidak boleh melebihi total RAB yang disetujui.'])->withInput();
        }

        // 4. Proses Simpan ke Database menggunakan Transaction
        DB::beginTransaction();
        try {
            // Buat entri LPJ utama (variabel $totalRealisasi digunakan di sini)
            $lpj = Lpj::create([
                'pengajuan_id' => $pengajuan->pengajuan_id,
                'total_realisasi' => $totalRealisasi,
                'status_lpj' => 'Menunggu Verifikasi',
                'tanggal_lapor' => now(),
            ]);

            // Simpan setiap item realisasi dan upload notanya
            foreach ($request->items as $index => $itemData) {
                $notaFile = $request->file("items.{$index}.nota");
                if (!$notaFile) continue;
            
                // Variabel $notaPath akan berisi -> "public/nota_lpj/namafileacak.jpg"
                $notaPath = $notaFile->store('public/nota_lpj');
            
                ItemLpj::create([
                    'lpj_id' => $lpj->lpj_id,
                    'nama_pengeluaran' => $itemData['nama_item'],
                    'jumlah_realisasi' => $itemData['jumlah'],
                    'satuan' => $itemData['satuan'],
                    'harga_realisasi' => $itemData['harga_satuan'],
                    
                    // Path yang disimpan di database adalah path tanpa "public/"
                    'path_foto_nota' => str_replace('public/', '', $notaPath),
                ]);
            }

            // Update status pengajuan menjadi 'Selesai'
            $statusSelesai = \App\Models\Status::where('nama_status', 'Selesai')->firstOrFail();
            $pengajuan->status()->associate($statusSelesai);
            $pengajuan->save();

            DB::commit();

            return redirect()->route('mahasiswa.lpj.index')->with('success', 'LPJ berhasil dikumpulkan dan sedang menunggu verifikasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['database' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi. Error: ' . $e->getMessage()])->withInput();
        }
    }
}