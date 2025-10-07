<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ormawa extends Model
{
    protected $primaryKey = 'ormawa_id';
    protected $fillable = ['nama_ormawa'];

    public function users() {
        return $this->hasMany(User::class, 'ormawa_id', 'ormawa_id');
    }

    public function pengajuan() {
        return $this->hasMany(Pengajuan::class, 'ormawa_id', 'ormawa_id');
    }
}
