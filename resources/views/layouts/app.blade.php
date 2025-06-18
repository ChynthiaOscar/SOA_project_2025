<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Nama Aplikasi')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CSS (misalnya Tailwind atau Bootstrap) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- FontAwesome Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('styles') <!-- Optional: untuk stylesheet tambahan -->
</head>

<body class="bg-[#ECE9CA] text-gray-900">


    <!-- Konten utama -->
    <main class="min-h-screen w-screen pt-10">
        @yield('content')
    </main>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('scripts') <!-- Optional: untuk script tambahan -->
</body>

</html>
