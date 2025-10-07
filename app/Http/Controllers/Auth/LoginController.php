<?php
// app/Http/Controllers/Auth/LoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman/form login
    public function showLoginForm() {
        return view('auth.login');
    }

    // Memproses data dari form login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba untuk login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = $user->role->role_name; // Mengambil nama peran

            // Arahkan berdasarkan peran
            return match ($role) {
                'mahasiswa'     => redirect()->intended(route('mahasiswa.dashboard')),
                'staf_ormawa'   => redirect()->intended(route('staf_ormawa.dashboard')),
                'staf_fakultas' => redirect()->intended(route('staf_fakultas.dashboard')),
                default         => redirect('/'),
            };
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}