<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <title>@yield('title', 'Nama Aplikasi')</title>

    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @stack('styles') <!-- Optional: untuk stylesheet tambahan -->
</head>
{{-- <body class="bg-[#131313]">" --}}

    <!-- Navbar -->
    {{-- @include('partials.navbar') --}}

    <!-- Konten utama -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts') 
</body>
</html>
