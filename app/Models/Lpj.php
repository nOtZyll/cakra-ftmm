<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lpj extends Model
{
    protected $primaryKey = 'lpj_id';

    public function pengajuan() {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }

    public function itemsLpj() {
        return $this->hasMany(ItemLpj::class, 'lpj_id', 'lpj_id');
    }
}
