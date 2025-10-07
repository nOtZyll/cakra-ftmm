    <?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;

    class RegisterController extends Controller
    {
        /**
         * Menampilkan halaman/form registrasi.
         */
        public function showRegistrationForm()
        {
            // Ambil semua data role dari database, kecuali 'admin'
            $roles = Role::where('role_name', '!=', 'admin')->get();

            // Kirim data roles ke view agar bisa ditampilkan di dropdown
            return view('auth.register', compact('roles'));
        }

        /**
         * Memproses data dari form registrasi.
         */
        public function register(Request $request)
        {
            // 1. Validasi semua input dari form
            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:100|unique:users,email', // Pastikan email unik di tabel users
                'password' => 'required|string|min:6|confirmed', // 'confirmed' akan mencocokkan dengan 'password_confirmation'
                'role_id' => 'required|exists:roles,role_id', // Pastikan role_id yang dipilih ada di tabel roles
            ]);

            // 2. Jika validasi berhasil, buat user baru di database
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password_hash' => Hash::make($request->password), // Enkripsi password
                'role_id' => $request->role_id,
            ]);

            // 3. Arahkan pengguna ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        }
    }
    
