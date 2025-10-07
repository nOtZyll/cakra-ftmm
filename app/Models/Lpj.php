<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lpj extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'lpj'; // <-- INI SOLUSINYA

    /**
     * Kunci utama untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'lpj_id';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'pengajuan_id',
        'tanggal_lapor',
        'total_realisasi',
        'status_lpj',
    ];

    /**
     * Mendapatkan pengajuan yang memiliki LPJ ini.
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }

    /**
     * Mendapatkan semua item rincian untuk LPJ ini.
     */
    public function itemsLpj()
    {
        return $this->hasMany(ItemLpj::class, 'lpj_id', 'lpj_id');
    }
}
