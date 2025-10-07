<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class HistoriStatus extends Model
{
    use HasFactory;
    protected $table = 'histori_status';
    protected $primaryKey = 'histori_id';

    public function pengajuan() {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }

    public function diubahOleh() {
        return $this->belongsTo(User::class, 'diubah_oleh_user_id', 'user_id');
    }
}
