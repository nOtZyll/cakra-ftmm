<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $primaryKey = 'status_id';
    protected $fillable = ['nama_status', 'deskripsi'];

    public function pengajuan() {
        return $this->hasMany(Pengajuan::class, 'current_status_id', 'status_id');
    }
}
