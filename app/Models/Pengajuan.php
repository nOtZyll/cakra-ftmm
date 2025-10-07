<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    protected $table = 'pengajuan';
    protected $primaryKey = 'pengajuan_id';
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    public function ormawa() {
        return $this->belongsTo(Ormawa::class, 'ormawa_id', 'ormawa_id');
    }
    
    public function jenisSurat() {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id', 'jenis_surat_id');
    }
    
    public function status() {
        return $this->belongsTo(Status::class, 'current_status_id', 'status_id');
    }
    
    public function itemsRab() {
        return $this->hasMany(ItemRab::class, 'pengajuan_id', 'pengajuan_id');
    }
    
    public function lpj() {
        return $this->hasOne(Lpj::class, 'pengajuan_id', 'pengajuan_id');
    }
    
    public function historiStatus() {
        return $this->hasMany(HistoriStatus::class, 'pengajuan_id', 'pengajuan_id');
    }
}
