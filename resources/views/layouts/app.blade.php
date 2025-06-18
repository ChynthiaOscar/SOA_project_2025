<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'Nama Aplikasi')</title>

      <script src="https://cdn.tailwindcss.com"></script>
    <!-- CSS (misalnya Tailwind atau Bootstrap) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @stack('styles') <!-- Optional: untuk stylesheet tambahan -->
</head>
<body class="bg-[#ECE9CA] text-gray-900">


    <!-- Konten utama -->
    <main class="min-h-screen w-screen pt-10">
        @yield('content')
    </main>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts') <!-- Optional: untuk script tambahan -->
</body>
</html>
