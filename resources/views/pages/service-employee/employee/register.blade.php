<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-black">
    <header class="bg-[#000000] p-4">
        <div
            class="w-24 h-12 bg-[#d9d9d9] flex items-center justify-center text-[#6b3f3f] text-xs font-semibold tracking-widest">
            LOGO
        </div>
    </header>
    <main class="flex justify-center items-center min-h-[calc(100vh-64px)]">
        <form method="POST" action="/api/employee/register" class="border border-[#bfa742] p-8 max-w-xs w-full"
            style="background-color: rgba(0,0,0,0.8);">
            @csrf
            <!-- ALERT SUCCESS -->
            @if(session('success'))
                <div class="mb-4 p-3 text-green-700 bg-green-100 border border-green-300 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ALERT ERROR -->
            @if($errors->any())
                <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-300 rounded text-sm">
                    <ul class="list-disc pl-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h1 class="text-[#bfa742] text-3xl font-semibold mb-8 text-center"
                style="font-family: 'Playfair Display', serif;">
                REGISTER
            </h1>
            <input type="text" placeholder="Name" name="name"
                class="w-full mb-4 px-3 py-2 border border-[#bfa742] rounded text-white/70 bg-transparent placeholder-white/50 focus:outline-none" />
            <input type="email" placeholder="Email" name="email"
                class="w-full mb-4 px-3 py-2 border border-[#bfa742] rounded text-white/70 bg-transparent placeholder-white/50 focus:outline-none" />
            <input type="password" placeholder="Password" name="password"
                class="w-full mb-6 px-3 py-2 border border-[#bfa742] rounded text-white/70 bg-transparent placeholder-white/50 focus:outline-none" />
            <button type="submit"
                class="w-full bg-[#7f1a12] text-[#bfa742] font-semibold py-3 rounded flex justify-center items-center gap-2 hover:brightness-110 transition">
                Register Now
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="#bfa742" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                </svg>
            </button>
            <p class="text-xs text-white text-center mt-6">
                Already have an account?
                <a href="{{ url('/employee/login') }}" class="italic text-[#7f1a12] hover:underline">Login
                    now</a>
            </p>

        </form>
    </main>
</body>

</html>
