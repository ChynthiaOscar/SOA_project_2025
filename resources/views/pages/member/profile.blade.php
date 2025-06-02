@extends('layouts.app')

@section('title', 'Profil Member')

@section('content')
<div class="min-h-screen bg-[#1E1E1E] flex items-center justify-center px-4 py-16">

    <div class="w-full max-w-4xl bg-[#65090D] shadow-2xl border border-[#A67D44] p-8 md:p-12 relative text-white">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            {{-- Avatar --}}
            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-[#E2BB4D] bg-center bg-cover shadow-lg"
                 style="background-image: url('https://www.freeiconspng.com/thumbs/profile-icon-png/account-profile-user-icon--icon-search-engine-10.png')">
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-[#E2BB4D]">{{ $member->nama }}</h1>
                <p class="text-md font-semibold text-[#A67D44] mt-1">Member</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 mt-6 text-lg font-bold">
                    <div class="flex items-center gap-3">
                        <img src="/images/mail.png" alt="Email Icon" class="w-5 h-5">
                        <p>{{ $member->email }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <img src="/images/date.png" alt="Email Icon" class="w-5 h-5">
                        <p>{{ $member->tanggal_lahir->format('d-m-Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3 sm:col-span-2">
                        <img src="/images/phone.png" alt="Phone Icon" class="w-5 h-5">
                        <p>{{ $member->no_hp }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-10 w-full">
            <a href="{{ route('profile.edit') }}"
            class="bg-[#E2BB4D] text-[#65090D] hover:bg-yellow-600 hover:text-white font-bold px-8 py-4 rounded-full transition text-base text-center w-full sm:w-auto">
                Edit Profile
            </a>

            <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <button type="submit"
                        class="bg-[#A67D44] text-white hover:bg-[#E2BB4D] hover:text-[#65090D] font-bold px-8 py-4 rounded-full transition text-base w-full sm:w-auto">
                    Logout
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
