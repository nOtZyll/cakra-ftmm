<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    protected $primaryKey = 'user_id';
    protected $fillable = ['name', 'email', 'password_hash', 'role_id', 'ormawa_id'];

    // Beri tahu Laravel nama kolom password kita adalah 'password_hash'
    public function getAuthPassword() {
        return $this->password_hash;
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
}