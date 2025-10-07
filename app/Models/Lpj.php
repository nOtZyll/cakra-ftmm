<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lpj extends Model
{
    use HasFactory;

    protected $table = 'lpj';
    protected $primaryKey = 'lpj_id';

    protected $fillable = [
        'pengajuan_id',
        'tanggal_lapor',
        'total_realisasi',
        'status_lpj',
        'komentar',
    ];

    protected $casts = [
        'pengajuan_id'    => 'integer',
        'total_realisasi' => 'decimal:2',
        'tanggal_lapor'   => 'datetime',
    ];

    /**
     * LPJ milik pengajuan tertentu.
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }

    /**
     * Item-item (nota) LPJ.
     */
    public function itemsLpj()
    {
    return $this->hasMany(ItemLpj::class, 'lpj_id', 'lpj_id');
    }

    public function items()
    {
        return $this->hasMany(ItemLpj::class, 'lpj_id', 'lpj_id');
    }
}
