<!-- filepath: resources/views/layouts/voucher.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nama Aplikasi')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-[#EEEACB] text-gray-900">

    <main class="min-h-screen">
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>