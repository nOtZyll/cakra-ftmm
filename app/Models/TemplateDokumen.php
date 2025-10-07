<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDokumen extends Model
{
    use HasFactory;
    protected $table = 'template_dokumen';
    protected $primaryKey = 'template_id';

    protected $fillable = [
        'jenis_surat_id',
        'nama_template',
        'link_template',
    ];

    public function jenisSurat() {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id', 'jenis_surat_id');
    }
}
