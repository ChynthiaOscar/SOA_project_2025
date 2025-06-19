<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-black min-h-screen flex flex-col">
    <header class="bg-[#000000] p-4">
        <div
            class="w-24 h-12 bg-[#d9d9d9] flex items-center justify-center text-[#6b3f3f] text-xs font-semibold tracking-widest">
            LOGO
        </div>
    </header>
    <main class="flex-grow flex items-center justify-center">
        <div style="background-color: rgba(0,0,0,0.8);">
            <form method="POST" action="/api/employee/login" class="w-80 border border-[#bfa742] p-8 flex flex-col gap-6" autocomplete="off">
                @csrf
                <h1 class="text-[#bfa742] text-3xl font-semibold text-center">
                    LOGIN
                </h1>
                <input name="email" type="email" placeholder="Email"
                    class="w-full px-3 py-2 border border-[#bfa742] rounded text-white/70 bg-transparent placeholder-white/50 focus:outline-none text-sm" />
                <input name="password" type="password" placeholder="Password"
                    class="w-full px-3 py-2 border border-[#bfa742] rounded text-white/70 bg-transparent placeholder-white/50 focus:outline-none text-sm" />
                <button type="submit"
                    class="w-full bg-[#7f1a12] text-[#bfa742] font-semibold py-3 rounded flex justify-center items-center gap-2 hover:brightness-110 transition">
                    Login to Your Account
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="#bfa742" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </button>
            
                <p class="text-xs text-white text-center">
                    Don’t have an account?
                    <a href="{{ url('/employee/register') }}" class="italic text-[#7f1a12] hover:underline">Register Now</a>
                </p>
                @if ($errors->has('login'))
                    <p class="text-xs text-center text-red-500 mt-2">
                        {{ $errors->first('login') }}
                    </p>
                @endif
            </form>
        </div>
    </main>
</body>



</html>
