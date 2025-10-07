<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
    public function run(): void {
        Role::create(['role_name' => 'mahasiswa']);
        Role::create(['role_name' => 'staf_ormawa']);
        Role::create(['role_name' => 'staf_fakultas']);
        Role::create(['role_name' => 'admin']);
    }
}

