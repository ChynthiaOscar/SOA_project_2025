<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'Nama Aplikasi')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-black text-[#d4af37] font-sans">

    <main class="min-h-screen">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>

