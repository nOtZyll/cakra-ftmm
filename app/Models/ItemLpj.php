<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemLpj extends Model
{
    use HasFactory;
    protected $table = 'item_lpj';
    protected $primaryKey = 'item_lpj_id';

    public function lpj() {
        return $this->belongsTo(Lpj::class, 'lpj_id', 'lpj_id');
    }
}
