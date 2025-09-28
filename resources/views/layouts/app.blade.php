<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CAKRA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

</head>
<body class="flex min-h-screen bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white">
    
    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="flex-1 flex flex-col">
        {{-- Navbar --}}
        @include('partials.navbar')

        {{-- Konten Halaman --}}
        <main class="p-6">
            @yield('content')
        </main>
    </div>
    @stack('scripts')

</body>
</html>
