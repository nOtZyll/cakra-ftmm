<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status'; 
    protected $primaryKey = 'status_id';
    protected $fillable = ['nama_status', 'deskripsi'];

    public function pengajuan() {
        return $this->hasMany(Pengajuan::class, 'current_status_id', 'status_id');
    }
}
