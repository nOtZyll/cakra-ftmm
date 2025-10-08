<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Ormawa;
use App\Models\JenisSurat;
use App\Models\ItemRab;
use App\Models\Status;
use App\Models\HistoriStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $pengajuanBerjalan = Pengajuan::with(['ormawa', 'status'])
            ->where('user_id', $user->user_id)
            ->whereNotIn('current_status_id', function ($query) {
                $query->select('status_id')->from('status')->whereIn('nama_status', ['Selesai', 'Ditolak']);
            })
            ->orderBy('tanggal_pengajuan', 'desc')
            ->take(3)
            ->get();

        $notifikasiRevisi = Pengajuan::with('status')
            ->where('user_id', $user->user_id)
            ->whereHas('status', function ($query) {
                $query->where('nama_status', 'Revisi');
            })
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return view('mahasiswa.dashboard', compact('user', 'pengajuanBerjalan', 'notifikasiRevisi'));
    }
    public function index()
    {
        $pengajuans = Pengajuan::with(['user', 'ormawa', 'status'])
            ->where('user_id', Auth::id())
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(10);

        return view('mahasiswa.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        $ormawas = Ormawa::orderBy('nama_ormawa')->get();
        $jenisSurats = JenisSurat::orderBy('nama_jenis')->get();
        return view('mahasiswa.pengajuan.create', compact('ormawas', 'jenisSurats'));
    }

    public function store(Request $request)
    {
        $totalRab = 0;
        foreach ($request->items as $item) {
            $totalRab += $item['jumlah'] * $item['harga_satuan'];
        }
        
        $statusAwal = Status::where('nama_status', 'Screening Ormawa')->first();
        if (!$statusAwal) {
             return back()->with('error', 'Status awal "Screening Ormawa" tidak ditemukan. Hubungi admin.');
        }

        DB::beginTransaction();
        try {
            $pengajuan = new Pengajuan();
            $pengajuan->user_id = Auth::id();
            $pengajuan->ormawa_id = $request->ormawa_id;
            $pengajuan->jenis_surat_id = $request->jenis_surat_id;
            $pengajuan->judul_kegiatan = $request->judul_kegiatan;
            $pengajuan->link_dokumen = $request->link_dokumen;
            $pengajuan->tanggal_pengajuan = Carbon::now();
            $pengajuan->total_rab = $totalRab;
            $pengajuan->current_status_id = $statusAwal->status_id;
            $pengajuan->save();

            foreach ($request->items as $itemData) {
                $itemRab = new ItemRab();
                $itemRab->pengajuan_id = $pengajuan->pengajuan_id;
                $itemRab->nama_item = $itemData['nama_item'];
                $itemRab->jumlah = $itemData['jumlah'];
                $itemRab->satuan = $itemData['satuan'];
                $itemRab->harga_satuan = $itemData['harga_satuan'];
                $itemRab->save();
            }

            $histori = new HistoriStatus();
            $histori->pengajuan_id = $pengajuan->pengajuan_id;
            $histori->status_id = $statusAwal->status_id;
            $histori->diubah_oleh_user_id = Auth::id();
            $histori->timestamp = Carbon::now();
            $histori->komentar = 'Pengajuan berhasil dibuat oleh mahasiswa.';
            $histori->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        return redirect()->route('mahasiswa.pengajuan.index')->with('success', 'Pengajuan berhasil dibuat dan sedang dalam proses screening!');
    }
    public function show(Pengajuan $pengajuan)
    {
        if ($pengajuan->ormawa_id !== Auth::user()->ormawa_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $pengajuan->load(['user', 'ormawa', 'status', 'itemsRab']);
        return view('mahasiswa.pengajuan.show', compact('pengajuan'));
    }
    public function edit(Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }
        if ($pengajuan->status->nama_status !== 'Revisi') {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->pengajuan_id)->with('error', 'Pengajuan ini tidak dapat diedit.');
        }

        $ormawas = Ormawa::all();
        $jenisSurats = JenisSurat::all();

        return view('mahasiswa.pengajuan.edit', compact('pengajuan', 'ormawas', 'jenisSurats'));
    }
    public function update(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'ormawa_id' => 'required|exists:ormawa,ormawa_id',
            'jenis_surat_id' => 'required|exists:jenis_surat,jenis_surat_id',
            'judul_kegiatan' => 'required|string|max:255',
            'link_dokumen' => 'required|url',
            'items' => 'required|array|min:1',
            // ... (validasi item sama seperti store)
        ]);
 
        $totalRab = 0;
        foreach ($request->items as $item) {
            $totalRab += $item['jumlah'] * $item['harga_satuan'];
        }
        
        // Status baru setelah direvisi, kembali ke 'Screening Ormawa'
        $statusBaru = Status::where('nama_status', 'Screening Ormawa')->first();

        DB::beginTransaction();
        try {
            // Update data utama pengajuan
            $pengajuan->ormawa_id = $request->ormawa_id;
            $pengajuan->jenis_surat_id = $request->jenis_surat_id;
            $pengajuan->judul_kegiatan = $request->judul_kegiatan;
            $pengajuan->link_dokumen = $request->link_dokumen;
            $pengajuan->total_rab = $totalRab;
            $pengajuan->current_status_id = $statusBaru->status_id;
            $pengajuan->save();

            // Hapus item RAB lama dan buat ulang dengan yang baru
            $pengajuan->itemsRab()->delete();
            foreach ($request->items as $itemData) {
                ItemRab::create([
                    'pengajuan_id' => $pengajuan->pengajuan_id,
                    'nama_item' => $itemData['nama_item'],
                    'jumlah' => $itemData['jumlah'],
                    'satuan' => $itemData['satuan'],
                    'harga_satuan' => $itemData['harga_satuan'],
                ]);
            }

            // Simpan histori status baru
            HistoriStatus::create([
                'pengajuan_id' => $pengajuan->pengajuan_id,
                'status_id' => $statusBaru->status_id,
                'diubah_oleh_user_id' => Auth::id(),
                'timestamp' => now(),
                'komentar' => 'Pengajuan telah direvisi dan diajukan kembali oleh mahasiswa.',
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // return back()->with('error', 'Gagal menyimpan perubahan: ' . $e->getMessage());
            dd($e);
        }

        return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->pengajuan_id)->with('success', 'Pengajuan berhasil diperbarui!');
        $pengajuan->load(['user', 'ormawa', 'status', 'jenisSurat', 'itemsRab', 'historiStatus.status', 'historiStatus.user']);
    }
}

