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
use Illuminate\Support\Facades\Storage;


class LpjController extends Controller
{
public function update(Request $request, Lpj $lpj)
{
    if ($lpj->pengajuan->user_id !== Auth::id()) {
        abort(403, 'Anda tidak berhak mengubah LPJ ini.');
    }

    if (! in_array($lpj->status_lpj, ['Perlu Revisi (Ormawa)', 'Perlu Revisi'])) {
        return redirect()->route('mahasiswa.lpj.index')
            ->with('info', 'LPJ ini tidak dalam status revisi.');
    }

    $validated = $request->validate([
        'items'                     => ['required','array','min:1'],
        'items.*.nama_item'         => ['required','string','max:255'],
        'items.*.jumlah'            => ['required','integer','min:1'],
        'items.*.satuan'            => ['required','string','max:50'],
        'items.*.harga_satuan'      => ['required','numeric','min:0'],
        'items.*.nota'              => ['nullable','file','mimes:jpeg,png,jpg,gif,pdf','max:5120'],
        'items.*.existing_path'     => ['nullable','string'],
        'link_gdocs'                => ['nullable', 'url', 'max:2048']
    ]);

    $totalRealisasi = 0;
    foreach ($validated['items'] as $it) {
        $totalRealisasi += (int)$it['jumlah'] * (float)$it['harga_satuan'];
    }
    if ($totalRealisasi > (float) $lpj->pengajuan->total_rab) {
        return back()->withErrors([
            'total_realisasi' => 'Total realisasi tidak boleh melebihi total RAB yang disetujui.'
        ])->withInput();
    }

    DB::transaction(function () use ($request, $lpj, $validated, $totalRealisasi) {
        $lpj->items()->delete();

        $rows = [];
        foreach ($validated['items'] as $idx => $it) {
            $notaPath = $it['existing_path'] ?? null;

            if ($request->hasFile("items.$idx.nota")) {
                $stored   = $request->file("items.$idx.nota")->store('nota_lpj', 'public');
                $notaPath = $stored;
            }

            $rows[] = [
                'lpj_id'           => $lpj->lpj_id,
                'nama_pengeluaran' => $it['nama_item'],
                'jumlah_realisasi' => (int)$it['jumlah'],
                'satuan'           => $it['satuan'],
                'harga_realisasi'  => (float)$it['harga_satuan'],
                'path_foto_nota'   => $notaPath,
            ];
        }
        $lpj->items()->createMany($rows);

        $lpj->update([
            'total_realisasi' => $totalRealisasi,
            'status_lpj'      => 'Menunggu Screening Ormawa',
            'tanggal_lapor'   => now(),
            'link_gdocs'      => $request->input('link_gdocs'),
        ]);
    });

    return redirect()
        ->route('mahasiswa.lpj.index')
        ->with('success', 'LPJ berhasil diperbarui & dikirim ulang untuk screening.');
}

    public function updateLpjStatus(Request $request, Lpj $lpj)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:setuju,revisi',
            'komentar' => 'nullable|string|max:1000',
            'link_gdocs' => 'nullable|url|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $action = $request->input('action');
        $komentar = $request->input('komentar');

        if ($action === 'setuju') {
            $lpj->status_lpj = 'Disetujui';
            $pesan = 'LPJ telah berhasil disetujui.';
        } else {
            if (empty($komentar)) {
                return back()->withErrors(['komentar' => 'Komentar wajib diisi untuk meminta revisi.'])->withInput();
            }
            $lpj->status_lpj = 'Perlu Revisi';
            $lpj->komentar = $komentar;
            $pesan = 'LPJ telah dikembalikan untuk revisi.';
        }
        
        $lpj->save();

        $namaStatusHistori = ($action === 'setuju') ? 'LPJ Disetujui' : 'LPJ Revisi';
        $statusUntukHistori = \App\Models\Status::where('nama_status', $namaStatusHistori)->first();

        if ($statusUntukHistori) {
            \App\Models\HistoriStatus::create([
                'pengajuan_id' => $lpj->pengajuan_id,
                'status_id' => $statusUntukHistori->status_id,
                'diubah_oleh_user_id' => \Illuminate\Support\Facades\Auth::id(),
                'komentar' => $komentar,
            ]);
        }

        return redirect()->route('staf_fakultas.dashboard')->with('success', $pesan);
    }
    public function index()
    {
        $user_id = Auth::id();

        $siapDibuat = Pengajuan::where('user_id', $user_id)
            ->whereHas('status', function ($query) {
                $query->whereIn('nama_status', ['Disetujui', 'Dana Cair']);
            })
            ->whereDoesntHave('lpj')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $perluDirevisi = Lpj::whereHas('pengajuan', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->whereIn('status_lpj', ['Perlu Revisi (Ormawa)', 'Perlu Revisi'])
            ->with('pengajuan')
            ->get();
            
        return view('mahasiswa.lpj.index', compact('siapDibuat', 'perluDirevisi'));
    }
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
        
        return view('mahasiswa.lpj.create', compact('pengajuan'));
    }
    public function edit($id)
    {
        $lpj = Lpj::with(['pengajuan', 'items'])->findOrFail($id);
        if ($lpj->pengajuan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengubah LPJ ini.');
        }
        return view('mahasiswa.lpj.edit', compact('lpj'));
    }

    public function store(Request $request, Pengajuan $pengajuan)
{
    $validator = Validator::make($request->all(), [
        'items' => 'required|array|min:1',
        'items.*.nama_item' => 'required|string|max:255',
        'items.*.jumlah' => 'required|integer|min:1',
        'items.*.satuan' => 'required|string|max:50',
        'items.*.harga_satuan' => 'required|numeric|min:0',
        'items.*.nota' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
    ]);
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $totalRealisasi = 0;
    foreach ($request->items as $item) {
        $totalRealisasi += $item['jumlah'] * $item['harga_satuan'];
    }
    if ($totalRealisasi > $pengajuan->total_rab) {
        return back()->withErrors(['total_realisasi' => 'Total realisasi tidak boleh melebihi total RAB yang disetujui.'])->withInput();
    }

    DB::beginTransaction();
    try {
        $lpj = Lpj::create([
            'pengajuan_id'     => $pengajuan->pengajuan_id,
            'total_realisasi'  => $totalRealisasi,
            'status_lpj'       => 'Menunggu Screening Ormawa',
            'tanggal_lapor'    => now(),
            'link_gdocs'      => $request->input('link_gdocs'),
        ]);

        foreach ($request->items as $index => $itemData) {
            $notaFile = $request->file("items.$index.nota");
            $stored    = $notaFile->store('nota_lpj', 'public');
            ItemLpj::create([
                'lpj_id'            => $lpj->lpj_id,
                'nama_pengeluaran'  => $itemData['nama_item'],
                'jumlah_realisasi'  => (int)$itemData['jumlah'],
                'satuan'            => $itemData['satuan'],
                'harga_realisasi'   => (float)$itemData['harga_satuan'],
                'path_foto_nota'    => $stored,
            ]);
        }

        DB::commit();
        return redirect()->route('mahasiswa.lpj.index')
            ->with('success', 'LPJ berhasil dikumpulkan dan sedang menunggu verifikasi.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['database' => 'Gagal menyimpan data. Error: '.$e->getMessage()])->withInput();
    }
}

}
