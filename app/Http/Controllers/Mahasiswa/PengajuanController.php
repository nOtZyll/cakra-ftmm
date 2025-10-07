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
    /**
     * Menampilkan halaman dashboard mahasiswa.
     */
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

    /**
     * Menampilkan halaman riwayat pengajuan.
     */
    public function index()
    {
        $pengajuans = Pengajuan::with(['user', 'ormawa', 'status'])
            ->where('user_id', Auth::id())
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(10);

        return view('mahasiswa.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Menampilkan form untuk membuat pengajuan baru.
     */
    public function create()
    {
        $ormawas = Ormawa::orderBy('nama_ormawa')->get();
        $jenisSurats = JenisSurat::orderBy('nama_jenis')->get();
        return view('mahasiswa.pengajuan.create', compact('ormawas', 'jenisSurats'));
    }

    /**
     * Menyimpan data pengajuan baru ke database.
     */
    public function store(Request $request)
    {
        /**
         * --- LANGKAH DEBUGGING ---
         * Hapus tanda komentar (//) dari baris di bawah ini untuk mengaktifkan dd().
         * Ini akan menghentikan semua proses dan menampilkan data yang dikirim dari form Anda.
         */
        // dd($request->all());

        // 1. Validasi semua input
        // $request->validate([
        //     'ormawa_id' => 'required|exists:ormawa,ormawa_id',
        //     'jenis_surat_id' => 'required|exists:jenis_surat,jenis_surat_id',
        //     'judul_kegiatan' => 'required|string|max:255',
        //     'link_dokumen' => 'required|url',
        //     'items' => 'required|array|min:1',
        //     'items.*.nama_item' => 'required|string|max:255',
        //     'items.*.jumlah' => 'required|integer|min:1',
        //     'items.*.satuan' => 'required|string|max:50',
        //     'items.*.harga_satuan' => 'required|numeric|min:0',
        // ]);

        // 2. Hitung total RAB
        $totalRab = 0;
        foreach ($request->items as $item) {
            $totalRab += $item['jumlah'] * $item['harga_satuan'];
        }
        
        // 3. Ambil status awal dari database
        $statusAwal = Status::where('nama_status', 'Screening Ormawa')->first();
        if (!$statusAwal) {
             return back()->with('error', 'Status awal "Screening Ormawa" tidak ditemukan. Hubungi admin.');
        }

        // 4. Gunakan Transaction untuk memastikan semua data tersimpan atau tidak sama sekali
        DB::beginTransaction();
        try {
            // Simpan data utama ke tabel 'pengajuan'
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

            // Simpan setiap item RAB ke tabel 'item_rab'
            foreach ($request->items as $itemData) {
                $itemRab = new ItemRab();
                $itemRab->pengajuan_id = $pengajuan->pengajuan_id;
                $itemRab->nama_item = $itemData['nama_item'];
                $itemRab->jumlah = $itemData['jumlah'];
                $itemRab->satuan = $itemData['satuan'];
                $itemRab->harga_satuan = $itemData['harga_satuan'];
                $itemRab->save();
            }

            // Simpan histori status pertama
            $histori = new HistoriStatus();
            $histori->pengajuan_id = $pengajuan->pengajuan_id;
            $histori->status_id = $statusAwal->status_id;
            $histori->diubah_oleh_user_id = Auth::id();
            $histori->timestamp = Carbon::now();
            $histori->komentar = 'Pengajuan berhasil dibuat oleh mahasiswa.';
            $histori->save();

            DB::commit(); // Konfirmasi semua penyimpanan jika tidak ada error
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            // Tampilkan pesan error untuk debugging
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        // 5. Arahkan kembali ke halaman riwayat dengan pesan sukses
        return redirect()->route('mahasiswa.pengajuan.index')->with('success', 'Pengajuan berhasil dibuat dan sedang dalam proses screening!');
    }

    /**
     * Menampilkan detail satu pengajuan.
     */
    public function show(Pengajuan $pengajuan)
    {
        /**
         * --- DEBUGGING WAJIB ---
         * Baris ini HARUS dieksekusi. Jika tidak, ada masalah di file rute.
         */

        // Kode di bawah ini tidak akan berjalan karena ada dd() di atas
        if ($pengajuan->ormawa_id !== Auth::user()->ormawa_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $pengajuan->load(['user', 'ormawa', 'status', 'itemsRab']);
        return view('mahasiswa.pengajuan.show', compact('pengajuan'));
    }
        /**
     * --- METHOD BARU: Menampilkan form untuk mengedit pengajuan ---
     */
    public function edit(Pengajuan $pengajuan)
    {
        // Proteksi: pastikan user hanya bisa mengedit pengajuannya sendiri
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }
        // Proteksi: pastikan hanya bisa diedit jika statusnya 'Revisi'
        if ($pengajuan->status->nama_status !== 'Revisi') {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->pengajuan_id)->with('error', 'Pengajuan ini tidak dapat diedit.');
        }

        $ormawas = Ormawa::all();
        $jenisSurats = JenisSurat::all();

        return view('mahasiswa.pengajuan.edit', compact('pengajuan', 'ormawas', 'jenisSurats'));
    }

    /**
     * --- METHOD BARU: Menyimpan perubahan dari form edit ---
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        // Proteksi
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi (sama seperti store)
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

