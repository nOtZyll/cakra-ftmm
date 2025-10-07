<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // <-- Import Rule untuk validasi canggih

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman/form registrasi.
     */
    public function showRegistrationForm()
    {
        // PERUBAHAN 1: Ambil semua role yang boleh mendaftar
        // Kita tambahkan 'staf_fakultas' ke dalam daftar
        $roles = Role::whereIn('role_name', ['mahasiswa', 'staf_ormawa', 'staf_fakultas'])->get();
        $ormawas = Ormawa::orderBy('nama_ormawa')->get();

        return view('auth.register', compact('roles', 'ormawas'));
    }

    /**
     * Memproses data dari form registrasi.
     */
    public function register(Request $request)
    {
        // Asumsi dari RoleSeeder: 1=mahasiswa, 2=staf_ormawa, 3=staf_fakultas
        $rolesWajibOrmawa = [1, 2];

        // PERUBAHAN 2: Perbarui aturan validasi
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,role_id',
            // Ormawa_id sekarang wajib diisi jika role_id adalah 1 (mahasiswa) ATAU 2 (staf_ormawa)
            'ormawa_id' => [
                Rule::requiredIf(in_array($request->role_id, $rolesWajibOrmawa)),
                'nullable',
                'exists:ormawa,ormawa_id'
            ],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'role_id' => $request->role_id,
            // Simpan ormawa_id jika role yang dipilih adalah mahasiswa atau staf ormawa
            'ormawa_id' => in_array($request->role_id, $rolesWajibOrmawa) ? $request->ormawa_id : null,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}

