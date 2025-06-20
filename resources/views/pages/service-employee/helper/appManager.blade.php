<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Manager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#ede7c7] min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-[#651b1b] w-56 flex flex-col p-6 text-[#e0a93a]">
        <div class="mb-10">
            <div
                class="bg-[#d9d9d9] text-[#651b1b] font-sans font-normal text-xs w-28 h-12 flex items-center justify-center">
                LOGO
            </div>
        </div>
        <div class="mb-10">
            <p class="font-semibold text-[#e0a93a] mb-1">{{ session('user.name') }}</p>
            <p class="text-xs text-[#e0a93a]">{{ session('user.email') }}</p>
        </div>
        <nav class="flex flex-col space-y-8 text-xs font-normal">
            <a href="{{ route('manager.employee_data') }}" class="flex items-center space-x-3">
                <i class="fas fa-search text-[#e0a93a] text-sm"></i>
                <span>Manage Employee</span>
            </a>
            <a href="{{ route('manager.schedule') }}" class="flex items-center space-x-3">
                <i class="far fa-bell text-[#e0a93a] text-sm"></i>
                <span>Schedule</span>
            </a>
            <a href="{{ route('manager.attendance') }}" class="flex items-center space-x-3">
                <i class="far fa-clock text-[#e0a93a] text-sm"></i>
                <span>Attendance</span>
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="flex items-center space-x-3">
                <i class="fas fa-calendar-alt text-[#e0a93a] text-sm"></i>
                <span>Reservations</span>
            </a>
            <a href="{{ route('admin.tables.index') }}" class="flex items-center space-x-3">
                <i class="fas fa-table text-[#e0a93a] text-sm"></i>
                <span>Tables</span>
            </a>
            <a href="{{ route('admin.slots.index') }}" class="flex items-center space-x-3">
                <i class="far fa-clock text-[#e0a93a] text-sm"></i>
                <span>Time Slots</span>
            </a>
            <a href="{{ route('employee.profile') }}" class="flex items-center space-x-3">
                <i class="far fa-id-card text-[#e0a93a] text-sm"></i>
                <span>Profile</span>
            </a>
        </nav>
        <div class="mt-auto pt-10">
            <form method="POST" action="{{ url('/api/employee/logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-2 text-xs text-[#e0a93a]">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-[#e0a93a] px-8 py-4">
            <h1 class="text-3xl font-extrabold text-[#1a1a1a]">@yield('header-title', 'Manager')</h1>
        </header>

        <!-- Content -->
        <section class="flex-1 px-8 py-6 relative">
            @yield('content')
        </section>
    </main>
</body>

</html>
