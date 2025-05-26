@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="mb-6 text-center">
    <h1 class="text-3xl font-bold text-[#E2BB4D]">Create Account</h1>
    <p class="text-white/80 italic">Join Nama Restoran</p>
</div>

@if($errors->any())
    <div class="mb-4 text-[#FF4E4E] text-sm bg-white/10 border border-red-500/30 px-4 py-2">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('register') }}" method="POST" class="form-font">
    @csrf

    <div class="mb-4">
        <label for="email" class="block text-sm font-semibold text-white/80">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               class="mt-1 w-full px-4 py-2 bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
               required placeholder="Enter your email">
    </div>

    <div class="mb-4">
        <label for="nama" class="block text-sm font-semibold text-white/80">Full Name</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
               class="mt-1 w-full px-4 py-2 bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
               required placeholder="Enter your full name">
    </div>

    <div class="mb-4">
        <label for="tanggal_lahir" class="block text-sm font-semibold text-white/80">Date of Birth</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
               class="mt-1 w-full px-4 py-2 bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
               required>
    </div>

    <div class="mb-4">
        <label for="no_hp" class="block text-sm font-semibold text-white/80">Phone Number</label>
        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
               class="mt-1 w-full px-4 py-2 bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
               required placeholder="08xxxxxxxxxx">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-semibold text-white/80">Password</label>
        <input type="password" name="password" id="password"
               class="mt-1 w-full px-4 py-2 bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
               required placeholder="Create a password">
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-semibold text-white/80">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
               class="mt-1 w-full px-4 py-2 rounded-lg bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
               required placeholder="Confirm your password">
    </div>

    <button type="submit"
            class="w-full py-2 rounded-lg bg-[#E2BB4D] text-black font-semibold hover:bg-[#f3cd62] transition">
        Register
    </button>
</form>

<p class="text-center text-sm text-white/70 mt-6">
    Already have an account?
    <a href="{{ route('login') }}" class="text-[#E2BB4D] hover:underline">Login</a>
</p>
@endsection
