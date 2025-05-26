@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="mb-6 text-center">
    <h1 class="text-3xl font-bold text-[#E2BB4D]">Forgot Password</h1>
    <p class="text-white/80 italic">Enter your email to reset your password</p>
</div>

@if (session('status'))
    <div class="mb-4 text-green-600 text-sm">
        {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 text-red-600 text-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('member.password.email') }}">
    @csrf
    <div class="mb-4">
        <label for="email" class="block text-sm font-semibold text-white/80">Email</label>
        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email') }}"
            required
            autofocus
            class="mt-1 w-full px-4 py-2 bg-white/10 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]"
        >
    </div>
    <button type="submit" class="w-full py-2 bg-[#E2BB4D] text-black font-semibold hover:bg-[#f3cd62] transition">
        Send Password Reset Link
    </button>
</form>

<p class="text-center text-sm text-white/70 mt-6">
    Remember your password?
    <a href="{{ route('login') }}" class="text-[#E2BB4D] hover:underline">Login</a>
</p>
@endsection
