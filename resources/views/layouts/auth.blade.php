<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />

    <title>@yield('title') - Chinese Restaurant</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Montserrat&display=swap" rel="stylesheet" />

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        body {
            font-family: 'DM Serif Display', serif;
        }
        .form-font {
            font-family: 'Montserrat', sans-serif;
        }

        /* Slow spin for decorative blobs */
        .animate-spin-slow {
            animation: spin 10s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Sparkle floating animation */
        @keyframes sparkle {
            0%, 100% { opacity: 0.3; transform: translateY(0); }
            50% { opacity: 1; transform: translateY(-10px); }
        }

        /* Glowing animation */
        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 10px #e2bb4d, 0 0 20px #e2bb4d, 0 0 30px #e2bb4d;
            }
            50% {
                box-shadow: 0 0 20px #ffd966, 0 0 30px #ffd966, 0 0 40px #ffd966;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-start bg-[#131313] relative px-4 overflow-x-hidden">

    <div class="absolute inset-0 z-0">
        <img src="/images/wallpaper.png" 
            alt="Chinese Food" 
            class="w-full h-full object-cover object-center fixed top-0 left-0 min-h-screen min-w-full" style="z-index:-1;" />
    </div>

    <!-- Title Section -->
    <header class="text-center mt-12 sm:mt-16 mb-6 z-10 px-4 sm:px-6">
        <h1 class="text-4xl sm:text-5xl font-bold text-[#E2BB4D]">
            Nama Restoran
        </h1>
        <p class="text-white text-base sm:text-lg mt-3 italic max-w-xl mx-auto">Deskripsi Singkat</p>
    </header>

    <!-- Content Section with Optional Illustration -->
    <main class="flex flex-col-reverse lg:flex-row items-center justify-center gap-8 w-full max-w-7xl z-10 px-4 md:px-6">

        <section class="mt-8 form-font bg-[#65090D]/80 backdrop-blur-md border border-[3px] border-[#A67D44] shadow-2xl p-6 sm:p-8 md:p-10 w-full lg:w-full max-w-md">
            @yield('content')
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-white text-xs sm:text-sm mt-12 mb-6 opacity-80 text-center z-10 px-4 sm:px-6">
        &copy; 2025 Nama Restoran. All rights reserved.
    </footer>

    <!-- Ornamen Sudut Kiri Atas
    <svg class="absolute top-0 left-0 w-10 h-10 text-[#E2BB4D] z-20" viewBox="0 0 100 100" fill="currentColor">
        <path d="M0,100 L0,0 L100,0 L100,20 L20,20 L20,100 Z" />
    </svg> -->

    <!-- Ornamen Sudut Kanan Atas -->
    <!-- <svg class="absolute top-0 right-0 w-10 h-10 text-[#E2BB4D] rotate-90 z-20" viewBox="0 0 100 100" fill="currentColor">
        <path d="M0,100 L0,0 L100,0 L100,20 L20,20 L20,100 Z" />
    </svg> -->

    <!-- Ornamen Sudut Kiri Bawah -->
    <!-- <svg class="absolute bottom-0 left-0 w-10 h-10 text-[#E2BB4D] -rotate-90 z-20" viewBox="0 0 100 100" fill="currentColor">
        <path d="M0,100 L0,0 L100,0 L100,20 L20,20 L20,100 Z" />
    </svg> -->

    <!-- Ornamen Sudut Kanan Bawah -->
    <!-- <svg class="absolute bottom-0 right-0 w-10 h-10 text-[#E2BB4D] rotate-180 z-20" viewBox="0 0 100 100" fill="currentColor">
        <path d="M0,100 L0,0 L100,0 L100,20 L20,20 L20,100 Z" />
    </svg> -->

    
</body>
</html>
