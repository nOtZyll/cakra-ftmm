<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateDokumen extends Model
{
    protected $primaryKey = 'template_id';

    public function jenisSurat() {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id', 'jenis_surat_id');
    }
}
