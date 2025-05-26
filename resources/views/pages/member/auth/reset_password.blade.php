@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="mb-6 text-center">
    <h1 class="text-3xl font-bold text-[#E2BB4D]">Reset Password</h1>
</div>

<form method="POST" action="{{ route('member.password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-4">
        <label for="email" class="block text-sm font-semibold text-white/80">Email</label>
        <input type="email" name="email" id="email" value="{{ request('email') }}" required
               class="mt-1 w-full px-4 py-2 border border-gray-300 focus:ring-2 focus:ring-red-500">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-semibold text-white/80">New Password</label>
        <input type="password" name="password" id="password" required
               class="mt-1 w-full px-4 py-2 border border-gray-300 focus:ring-2 focus:ring-red-500">
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-semibold text-white/80">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required
               class="mt-1 w-full px-4 py-2 border border-gray-300 focus:ring-2 focus:ring-red-500">
    </div>

    <button type="submit" class="w-full py-2 bg-[#E2BB4D] text-black font-semibold hover:bg-[#f3cd62] transition">
        Reset Password
    </button>
</form>
@endsection
