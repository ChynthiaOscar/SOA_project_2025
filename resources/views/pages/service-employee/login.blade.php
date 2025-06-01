<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap");
    </style>
</head>

<body class="bg-[#121212] min-h-screen flex flex-col">
    <header class="p-4">
        <div
            class="w-32 h-16 bg-gray-300 flex items-center justify-center text-[10px] text-[#6b2a2a] font-sans font-normal">
            LOGO
        </div>
    </header>
    <main class="flex-grow flex items-center justify-center">
        <div class="border border-[#111111] p-8">
            <form class="w-80 border border-[#a88f5a] p-8 flex flex-col gap-6" autocomplete="off">
                <h1 class="text-[#d6bf6f] font-serif font-extrabold text-3xl text-center">
                    LOGIN
                </h1>
                <input type="email" placeholder="Email"
                    class="bg-transparent border border-[#a88f5a] text-[#a88f5a] text-xs font-mono px-3 py-2 outline-none" />
                <input type="password" placeholder="Password"
                    class="bg-transparent border border-[#a88f5a] text-[#a88f5a] text-xs font-mono px-3 py-2 outline-none" />
                <button type="submit"
                    class="bg-[#6b1a1a] text-[#d6bf6f] font-semibold text-xs py-3 rounded flex items-center justify-center gap-2">
                    Login to Your Account
                    <i class="fas fa-arrow-right"></i>
                </button>
                <p class="text-[#a88f5a] italic text-xs text-right -mt-2">
                    Forgot password?
                </p>
                <p class="text-white text-[10px] text-center font-sans">
                    Don’t have an account?
                    <span class="text-[#6b1a1a] italic">Register Now</span>
                </p>
            </form>
        </div>
    </main>
</body>

</html>
