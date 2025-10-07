<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRab extends Model
{
    use HasFactory;

    protected $table = 'item_rab';
    protected $primaryKey = 'item_rab_id';

    /**
     * --- TAMBAHKAN INI ---
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'pengajuan_id',
        'nama_item',
        'jumlah',
        'satuan',
        'harga_satuan',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }
}