<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemLpj extends Model
{
    protected $primaryKey = 'item_lpj_id';

    public function lpj() {
        return $this->belongsTo(Lpj::class, 'lpj_id', 'lpj_id');
    }
}
