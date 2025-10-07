<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRab extends Model
{
    protected $primaryKey = 'item_rab_id';

    public function pengajuan() {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }
}
