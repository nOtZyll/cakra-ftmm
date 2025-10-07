    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Daftar Akun - CAKRA</title>
      <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
      <script>
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: { primary: '#741847', 'navy-base': '#073763', 'card-bg': 'rgba(255, 255, 255, 0.05)' },
              fontFamily: { display: ["Poppins", "sans-serif"] },
              borderRadius: { DEFAULT: "0.75rem" },
            },
          },
        };
      </script>
      <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background-color: #0a192f; background-image: radial-gradient(circle at top right, rgba(13, 17, 23, 0.5) 0%, #0a192f 50%), radial-gradient(circle at bottom left, rgba(255, 215, 0, 0.1) 0%, transparent 30%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-glow { box-shadow: 0 0 15px rgba(255, 215, 0, 0.1), 0 0 30px rgba(255, 215, 0, 0.05); }
      </style>
    </head>
    <body class="gradient-bg text-white">

      <main class="w-full max-w-md p-8 space-y-8">
        <div class="text-center">
          <h1 class="text-3xl font-bold tracking-wider">Buat Akun Baru</h1>
          <p class="text-white mt-2">Daftar untuk mulai menggunakan CAKRA FTMM.</p>
        </div>

        <div class="bg-card-bg backdrop-blur-sm p-8 rounded-2xl card-glow border border-primary/20">
          <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
            <div>
              <label for="name" class="block text-sm mb-1 text-white">Nama Lengkap</label>
              <input type="text" name="name" id="name" required placeholder="Masukkan nama lengkap" value="{{ old('name') }}"
                class="block w-full rounded-md border-0 bg-white/5 py-2.5 px-3 text-white ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm"/>
              @error('name')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-sm mb-1 text-white">Email</label>
              <input type="email" name="email" id="email" required placeholder="Masukkan email" value="{{ old('email') }}"
                class="block w-full rounded-md border-0 bg-white/5 py-2.5 px-3 text-white ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm"/>
              @error('email')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block text-sm mb-1 text-white">Password</label>
              <input type="password" name="password" id="password" required placeholder="Minimal 6 karakter"
                class="block w-full rounded-md border-0 bg-white/5 py-2.5 px-3 text-white ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm"/>
              @error('password')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
              <label for="password_confirmation" class="block text-sm mb-1 text-white">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password"
                class="block w-full rounded-md border-0 bg-white/5 py-2.5 px-3 text-white ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm"/>
            </div>

            <!-- Role -->
            <div>
              <label for="role_id" class="block text-sm mb-1 text-white">Daftar sebagai</label>
              <select name="role_id" id="role_id" required
                class="block w-full rounded-md border-0 bg-white/5 py-2.5 px-3 text-white ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm">
                <option value="" disabled selected>Pilih peran Anda</option>
                @foreach ($roles as $role)
                  <option value="{{ $role->role_id }}">{{ Str::ucfirst(str_replace('_', ' ', $role->role_name)) }}</option>
                @endforeach
              </select>
              @error('role_id')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Tombol Daftar -->
            <button type="submit"
              class="flex w-full justify-center rounded-md bg-primary px-3 py-2.5 text-sm font-semibold leading-6 text-navy-base shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all duration-300 transform hover:scale-105 mt-6">
              Daftar
            </button>
            
            <p class="text-center text-sm text-gray-400 pt-4">
              Sudah punya akun?
              <a href="{{ route('login') }}" class="font-semibold text-white hover:text-primary/80">Login di sini</a>
            </p>

          </form>
        </div>
      </main>
    </body>
    </html>
    
