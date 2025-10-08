<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {

        $roles = Role::whereIn('role_name', ['mahasiswa', 'staf_ormawa', 'staf_fakultas'])->get();
        $ormawas = Ormawa::orderBy('nama_ormawa')->get();
        return view('auth.register', compact('roles', 'ormawas'));
    }

    public function register(Request $request)
    {
        $rolesWajibOrmawa = [1, 2];
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,role_id',
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
            'ormawa_id' => in_array($request->role_id, $rolesWajibOrmawa) ? $request->ormawa_id : null,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}

