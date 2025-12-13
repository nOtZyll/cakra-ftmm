<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buat Password Baru - CAKRA</title>
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
      <h2 class="text-2xl font-semibold text-center mb-6">Password Baru</h2>

      @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-600 text-white text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
          <label class="block text-sm mb-1 text-subtle-text-dark">Email</label>
          <div class="relative">
            <span class="material-icons absolute inset-y-0 left-0 flex items-center pl-3 text-subtle-text-dark">email</span>
            <input type="email" name="email" required value="{{ old('email', $request->email) }}" readonly
              class="block w-full rounded-md border-0 bg-white/5 py-2.5 pl-10 pr-3 text-gray-400 cursor-not-allowed ring-1 ring-inset ring-white/10 focus:ring-0 sm:text-sm"/>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1 text-subtle-text-dark">Password Baru</label>
          <div class="relative">
            <span class="material-icons absolute inset-y-0 left-0 flex items-center pl-3 text-subtle-text-dark">lock</span>
            <input type="password" name="password" required autofocus placeholder="Minimal 8 karakter"
              class="block w-full rounded-md border-0 bg-white/5 py-2.5 pl-10 pr-3 text-white ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm"/>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1 text-subtle-text-dark">Ulangi Password</label>
          <div class="relative">
            <span class="material-icons absolute inset-y-0 left-0 flex items-center pl-3 text-subtle-text-dark">lock_reset</span>
            <input type="password" name="password_confirmation" required placeholder="Ketik ulang password baru"
              class="block w-full rounded-md border-0 bg-white/5 py-2.5 pl-10 pr-3 text-white ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm"/>
          </div>
        </div>

        <button type="submit"
          class="flex w-full justify-center rounded-md bg-primary px-3 py-2.5 text-sm font-semibold leading-6 text-navy-base shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all duration-300 transform hover:scale-105 mt-6">
          Ubah Password
        </button>
      </form>
    </div>
  </main>
</body>
</html>