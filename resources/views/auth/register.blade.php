<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar CAKRA</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#0f172a] to-[#1e293b]">
  <div class="w-full max-w-md bg-[#0f172a]/80 rounded-xl shadow-lg p-8 border border-gray-700">
    
    <!-- Judul -->
    <div class="text-center mb-6">
      <h1 class="text-2xl font-bold text-white">Daftar Akun CAKRA</h1>
      <p class="text-gray-400 text-sm">Silakan isi data di bawah untuk membuat akun</p>
    </div>

    <!-- Form Register -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
      @csrf

      <!-- Email -->
      <div>
        <label class="block text-gray-300 text-sm mb-1">Email</label>
        <input type="email" name="email" class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg" placeholder="Masukkan email" required>
      </div>

      <!-- Password -->
      <div>
        <label class="block text-gray-300 text-sm mb-1">Password</label>
        <input type="password" name="password" class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg" placeholder="Masukkan password" required>
      </div>

      <!-- Konfirmasi Password -->
      <div>
        <label class="block text-gray-300 text-sm mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg" placeholder="Ulangi password" required>
      </div>

      <!-- Role -->
      <div>
        <label class="block text-gray-300 text-sm mb-1">Daftar sebagai</label>
        <select name="role" class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg">
          <option value="mahasiswa">Mahasiswa</option>
          <option value="staf_ormawa">Staff Ormawa</option>
          <option value="staf_fakultas">Staff Keuangan Fakultas</option>
          <option value="stakeholder">Dekan</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <!-- Tombol Register -->
      <button type="submit" class="w-full bg-yellow-400 text-black font-semibold py-2 rounded-lg hover:bg-yellow-500 transition">
        Daftar
      </button>
    </form>

    <!-- Link balik ke login -->
    <p class="mt-6 text-center text-sm text-gray-400">
      Sudah punya akun? 
      <a href="{{ route('login') }}" class="text-yellow-400 hover:underline">Login</a>
    </p>
  </div>
</body>
</html>
