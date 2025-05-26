<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'Nama Aplikasi')</title>

    <!-- CSS (misalnya Tailwind atau Bootstrap) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @stack('styles') <!-- Optional: untuk stylesheet tambahan -->
</head>
<body class="bg-[#131313] text-gray-900">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Konten utama -->
    <main class="min-h-screen py-16">
        @yield('content')
    </main>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts') <!-- Optional: untuk script tambahan -->
</body>
</html>