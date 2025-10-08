<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemLpj extends Model
{
    use HasFactory;
    protected $table = 'item_lpj';
    protected $primaryKey = 'item_lpj_id';
    protected $fillable = [
        'lpj_id',
        'nama_pengeluaran',
        'jumlah_realisasi',
        'satuan',
        'harga_realisasi',
        'path_foto_nota',
    ];
    public function lpj() {
        return $this->belongsTo(Lpj::class, 'lpj_id', 'lpj_id');
    }
}
