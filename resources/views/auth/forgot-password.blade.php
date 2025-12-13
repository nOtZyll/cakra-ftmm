<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lupa Password - CAKRA</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: '#741847',
            'navy-base': '#073763',
            'navy-light': '#0A192F',
            'text-dark': '#e2e8f0',
            'subtle-text-dark': '#ffffff',
            'card-bg': 'rgba(255, 255, 255, 0.05)',
            'dropdown-bg': '#1e293b',
            'dropdown-text': '#ffffff',
            'dropdown-hover': '#334155',
          },
          fontFamily: {
            display: ["Poppins", "sans-serif"],
          },
          borderRadius: {
            DEFAULT: "0.75rem",
          },
        },
      },
    };
  </script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
    }
    .gradient-bg {
      background-color: #0a192f;
      background-image:
        radial-gradient(circle at top right, rgba(13, 17, 23, 0.5) 0%, #0a192f 50%),
        radial-gradient(circle at bottom left, rgba(255, 215, 0, 0.1) 0%, transparent 30%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card-glow {
      box-shadow: 0 0 15px rgba(255, 215, 0, 0.1), 0 0 30px rgba(255, 215, 0, 0.05);
    }
  </style>
</head>
<body class="gradient-bg text-white">

  <main class="w-full max-w-md p-8 space-y-8">
    <div class="text-center">
      <img alt="Logo FTMM" class="mx-auto h-16 w-auto mb-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCglN4LvFfZHBCoXvx1T5VIKS6B2b5FkJ6kW8KMID5fF7cx27QdrHhA7wHi-Xd3mn6cOX8aFOAQYwd3y-1_cZnzdDwzl7R7fxMweNKXaZyrPq1vTiEDKN_pceYuc0zyRJ0C8ppvfMPW8wKYc-ATX56I8jwnNbNsoB0PICTXCLU-GGtiP328IPc8VytxzWhZRCQt3Xn6-vGZuyRh9BLIyPr_OHszDo7MKkXbS7svp5QSKjF7VA6bIfY7XnMdH3PVXRON1sbHekZX2ss"/>
      <h1 class="text-3xl font-bold tracking-wider">CAKRA FTMM</h1>
      <p class="text-subtle-text-dark mt-2">Central Administrasi Keuangan dan Rencana Anggaran</p>
    </div>

    <div class="bg-card-bg backdrop-blur-sm p-8 rounded-2xl card-glow border border-primary/20">
      <h2 class="text-2xl font-semibold text-center mb-2">Reset Password</h2>
      
      <p class="text-sm text-gray-300 text-center mb-6">
        Lupa password? Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.
      </p>

      @if (session('status'))
        <div class="mb-4 p-3 rounded-lg bg-green-600 text-white text-sm text-center">
            {{ session('status') }}
        </div>
      @endif

      @error('email')
        <div class="mb-4 p-3 rounded-lg bg-red-600 text-white text-sm text-center">
            {{ $message }}
        </div>
      @enderror

      <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
          <label class="block text-sm mb-1 text-subtle-text-dark">Email</label>
          <div class="relative">
            <span class="material-icons absolute inset-y-0 left-0 flex items-center pl-3 text-subtle-text-dark">email</span>
            <input type="email" name="email" required autofocus placeholder="Masukkan email terdaftar" value="{{ old('email') }}"
              class="block w-full rounded-md border-0 bg-white/5 py-2.5 pl-10 pr-3 text-white ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm"/>
          </div>
        </div>

        <button type="submit"
          class="flex w-full justify-center rounded-md bg-primary px-3 py-2.5 text-sm font-semibold leading-6 text-navy-base shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all duration-300 transform hover:scale-105">
          Kirim Link Reset
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition-colors">
                &larr; Kembali ke Login
            </a>
        </div>
      </form>
    </div>

    <p class="text-center text-sm text-subtle-text-dark">
      Fakultas Teknologi Maju dan Multidisiplin
    </p>
  </main>
</body>
</html>