@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="mb-6 text-center">
    <h1 class="text-3xl font-bold text-[#E2BB4D]">Welcome Back</h1>
    <p class="text-white/80 italic">Login to your account</p>
</div>

<form method="POST" action="{{ route('login') }}" class="form-font">
    @csrf
    <div class="mb-4">
        <label for="email" class="block text-sm font-semibold text-white/80">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
               class="mt-1 w-full px-4 py-2 bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
               placeholder="Enter your email">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-semibold text-white/80">Password</label>
        <input id="password" type="password" name="password" required
               class="mt-1 w-full px-4 py-2 bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
               placeholder="Enter your password">
    </div>
    <button type="submit"
            class="w-full py-2 bg-[#E2BB4D] text-black font-semibold hover:bg-[#f3cd62] transition">
        Login
    </button>
</form>

<p class="text-center text-sm text-white/70 mt-6">
    Don't have an account?
    <a href="{{ route('register') }}" class="text-[#E2BB4D] hover:underline">Register</a>
</p>
@endsection
