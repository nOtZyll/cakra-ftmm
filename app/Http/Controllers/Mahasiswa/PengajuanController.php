<?php
namespace App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Menambahkan model yang diperlukan
use App\Models\Ormawa;
use App\Models\JenisSurat;
use App\Models\ItemRab;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PengajuanController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil 3 pengajuan terakhir yang statusnya belum 'Selesai' atau 'Ditolak'
        $pengajuanBerjalan = Pengajuan::with(['ormawa', 'status'])
            ->where('user_id', $user->user_id)
            ->whereNotIn('current_status_id', function ($query) {
                $query->select('status_id')->from('status')->whereIn('nama_status', ['Selesai', 'Ditolak']);
            })
            ->orderBy('tanggal_pengajuan', 'desc')
            ->take(3)
            ->get();

        // Ambil 3 notifikasi revisi terakhir
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
        // ... (method index yang sudah ada, tidak perlu diubah)
        $pengajuans = Pengajuan::with(['user', 'ormawa', 'status'])
            ->where('user_id', Auth::id())
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(10);
        return view('mahasiswa.pengajuan.index', compact('pengajuans'));
    }
    /**
     * --- METHOD BARU: Menampilkan form untuk membuat pengajuan baru ---
     */
    public function create()
    {
        // Ambil data untuk dropdown dari database
        $ormawas = Ormawa::orderBy('nama_ormawa')->get();
        $jenisSurats = JenisSurat::orderBy('nama_jenis')->get();
        // Kirim data ke view
        return view('mahasiswa.pengajuan.create', compact('ormawas', 'jenisSurats'));
    }
    /**
     * --- METHOD BARU: Menyimpan data pengajuan baru ke database ---
     */
    public function store(Request $request)
    {
        // 1. Validasi data utama
        $request->validate([
            'ormawa_id' => 'required|exists:ormawa,ormawa_id',
            'jenis_surat_id' => 'required|exists:jenis_surat,jenis_surat_id',
            'judul_kegiatan' => 'required|string|max:255',
            'link_dokumen' => 'required|url',
            'items' => 'required|array|min:1',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.harga_satuan' => 'required|integer|min:0',
        ]);
        // 2. Hitung total RAB dari semua item
        $totalRab = 0;
        foreach ($request->items as $item) {
            $totalRab += $item['jumlah'] * $item['harga_satuan'];
        }
        
        // Dapatkan status awal, misal 'Screening Ormawa'
        $statusAwal = Status::where('nama_status', 'Screening Ormawa')->first();
        if (!$statusAwal) {
             return back()->with('error', 'Status awal tidak ditemukan. Hubungi admin.');
        }
        // 3. Simpan data menggunakan Transaction untuk keamanan
        DB::beginTransaction();
        try {
            // Simpan data ke tabel 'pengajuan'
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
            // Simpan setiap item ke tabel 'item_rab'
            foreach ($request->items as $itemData) {
                $itemRab = new ItemRab();
                $itemRab->pengajuan_id = $pengajuan->pengajuan_id;
                $itemRab->nama_item = $itemData['nama_item'];
                $itemRab->jumlah = $itemData['jumlah'];
                $itemRab->satuan = $itemData['satuan'];
                $itemRab->harga_satuan = $itemData['harga_satuan'];
                $itemRab->save();
            }
            DB::commit(); // Jika semua berhasil, simpan permanen
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, batalkan semua
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data. Coba lagi.');
        }
        // 4. Arahkan ke halaman riwayat dengan pesan sukses
        return redirect()->route('mahasiswa.pengajuan.index')->with('success', 'Pengajuan berhasil dibuat!');
    }
    /**
     * --- METHOD BARU: Menampilkan detail satu pengajuan ---
     */
    public function show(Pengajuan $pengajuan)
    {
        // Pastikan mahasiswa hanya bisa melihat pengajuannya sendiri
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Load relasi yang dibutuhkan
        $pengajuan->load(['user', 'ormawa', 'status', 'jenisSurat', 'itemsRab', 'historiStatus.status', 'historiStatus.user']);
        return view('mahasiswa.pengajuan.show', compact('pengajuan'));
    }
}
