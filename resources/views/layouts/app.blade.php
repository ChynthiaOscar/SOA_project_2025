<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restaurant Review System') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }
        .navbar-brand {
            font-weight: 700;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
            margin-bottom: 1.5rem;
            border: none;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f0f0f0;
            font-weight: bold;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Restaurant Review System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reviews.index') ? 'active' : '' }}" href="{{ route('reviews.index') }}">All Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reviews.form') ? 'active' : '' }}" href="{{ route('reviews.form') }}">Write a Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reviews.history') ? 'active' : '' }}" href="{{ route('reviews.history') }}">My Reviews</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
