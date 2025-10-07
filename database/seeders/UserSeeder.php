<?php

namespace Database\Seeders;

// database/seeders/UserSeeder.php
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        // Membuat satu user mahasiswa untuk testing
        User::create([
            'name' => 'Budi Mahasiswa',
            'email' => 'mahasiswa@test.com',
            'password_hash' => Hash::make('password'), // Passwordnya: "password"
            'role_id' => 1, // Asumsi 'mahasiswa' adalah role dengan id=1
        ]);
    }
}

