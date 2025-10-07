<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;
    protected $table = 'jenis_surat';
    protected $primaryKey = 'jenis_surat_id';
    protected $fillable = ['nama_jenis'];

    public function pengajuan() {
        return $this->hasMany(Pengajuan::class, 'jenis_surat_id', 'jenis_surat_id');
    }

    public function templateDokumen() {
        return $this->hasMany(TemplateDokumen::class, 'jenis_surat_id', 'jenis_surat_id');
    }
}
