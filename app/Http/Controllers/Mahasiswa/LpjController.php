<?php
namespace App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Lpj;
use App\Models\ItemLpj;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class LpjController extends Controller
{
    /**
     * Menampilkan halaman untuk memilih pengajuan yang akan dibuatkan LPJ.
     */
    public function index()
    {
        // Ambil semua pengajuan milik user yang sudah disetujui (misal status 'Dana Cair')
        // dan belum memiliki LPJ.
        $pengajuans = Pengajuan::where('user_id', Auth::id())
            ->whereHas('status', function ($query) {
                $query->where('nama_status', 'Dana Cair'); // Sesuaikan dengan nama status Anda
            })
            ->whereDoesntHave('lpj') // Hanya yang belum punya LPJ
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();
        return view('mahasiswa.lpj.index', compact('pengajuans'));
    }
    /**
     * Menampilkan form untuk membuat LPJ berdasarkan pengajuan yang dipilih.
     */
    public function create(Pengajuan $pengajuan)
    {
        // Proteksi: Pastikan user hanya bisa membuat LPJ untuk pengajuannya sendiri
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }
        return view('mahasiswa.lpj.create', compact('pengajuan'));
    }
    /**
     * Menyimpan data LPJ baru ke database.
     */
    public function store(Request $request, Pengajuan $pengajuan)
    {
        // Proteksi: Pastikan user hanya bisa menyimpan LPJ untuk pengajuannya sendiri
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }
        // 1. Validasi
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.harga_satuan' => 'required|integer|min:0',
            'items.*.nota' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi file nota
        ]);
        // 2. Hitung total realisasi & validasi
        $totalRealisasi = 0;
        foreach ($request->items as $item) {
            $totalRealisasi += $item['jumlah'] * $item['harga_satuan'];
        }
        if ($totalRealisasi > $pengajuan->total_rab) {
            return back()->withErrors(['total' => 'Total realisasi tidak boleh melebihi total RAB yang disetujui.']);
        }
        
        DB::beginTransaction();
        try {
            // 3. Simpan data ke tabel 'lpj'
            $lpj = new Lpj();
            $lpj->pengajuan_id = $pengajuan->pengajuan_id;
            $lpj->tanggal_lapor = now();
            $lpj->total_realisasi = $totalRealisasi;
            $lpj->status_lpj = 'Menunggu Verifikasi'; // Status awal LPJ
            $lpj->save();
            // 4. Simpan setiap item dan upload notanya
            foreach ($request->file('items') as $index => $fileData) {
                $itemData = $request->input('items')[$index];
                // Upload file nota ke storage
                $path = $fileData['nota']->store('public/nota_lpj');
                // Simpan data ke tabel 'item_lpj'
                $itemLpj = new ItemLpj();
                $itemLpj->lpj_id = $lpj->lpj_id;
                $itemLpj->nama_pengeluaran = $itemData['nama_item'];
                $itemLpj->jumlah_realisasi = $itemData['jumlah'];
                $itemLpj->satuan = $itemData['satuan'];
                $itemLpj->harga_realisasi = $itemData['harga_satuan'];
                $itemLpj->path_foto_nota = $path;
                $itemLpj->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan LPJ: ' . $e->getMessage());
        }
        // 5. Arahkan kembali ke halaman riwayat pengajuan
        return redirect()->route('mahasiswa.pengajuan.index')->with('success', 'LPJ berhasil dikumpulkan dan sedang menunggu verifikasi.');
    }
}
