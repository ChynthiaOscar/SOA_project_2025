@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-2xl md:max-w-3xl lg:max-w-6xl flex flex-col lg:flex-row items-center h-auto lg:h-screen flex-wrap mx-auto my-10 md:my-20 lg:my-0 relative px-2 md:px-6">
    
    {{-- Profile Card --}}
    <div class="w-full lg:w-2/3 shadow-2xl bg-[#65090D] opacity-95 border-4 border-[#A67D44] mx-0 md:mx-4 lg:mx-0">
        <div class="p-4 sm:p-8 md:p-10 lg:p-16 text-center lg:text-left">
            
            {{-- Mobile Profile Picture --}}
            <div class="block lg:hidden shadow-xl mx-auto -mt-16 md:-mt-20 h-32 w-32 md:h-40 md:w-40 bg-cover bg-center border-4 border-[#A67D44]"
                 style="background-image: url('https://www.freeiconspng.com/thumbs/profile-icon-png/account-profile-user-icon--icon-search-engine-10.png')">
            </div>

            {{-- Member Name --}}
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold pt-6 md:pt-10 lg:pt-0 text-[#E2BB4D]">
                {{ $member->nama }}
            </h1>

            <div class="mx-auto lg:mx-0 w-4/5 pt-2 md:pt-4 border-b-2 border-[#E2BB4D] opacity-25"></div>

            {{-- Role --}}
            <p class="pt-4 md:pt-6 text-base md:text-lg font-bold flex items-center justify-center lg:justify-start text-white">
                <svg class="h-5 fill-current text-[#E2BB4D] pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="..." />
                </svg>
                Member
            </p>

            {{-- Email --}}
            <p class="pt-2 md:pt-3 text-[#E2BB4D] text-sm md:text-base lg:text-lg flex items-center justify-center lg:justify-start">
                <svg class="h-5 fill-current text-[#E2BB4D] pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="..." />
                </svg>
                {{ $member->email }}
            </p>

            {{-- Phone Number --}}
            <p class="pt-2 md:pt-3 text-white text-sm md:text-base lg:text-lg flex items-center justify-center lg:justify-start">
                <svg class="h-5 fill-current text-[#E2BB4D] pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="..." />
                </svg>
                {{ $member->no_hp }}
            </p>

            {{-- Date of Birth --}}
            <p class="pt-2 md:pt-3 text-[#E2BB4D] text-sm md:text-base lg:text-lg flex items-center justify-center lg:justify-start">
                <svg class="h-5 fill-current text-[#E2BB4D] pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="..." />
                </svg>
                {{ $member->tanggal_lahir->format('d-m-Y') }}
            </p>

            {{-- Edit Profile Button --}}
            <div class="pt-8 md:pt-10 pb-8 md:pb-10 mt-4 text-center">
                <a href="{{ route('profile.edit') }}" class="bg-[#E2BB4D] hover:bg-yellow-600 text-[#65090D] font-bold py-2 md:py-3 px-6 md:px-8 text-base md:text-lg transition">
                    Edit Profil
                </a>
            </div>

            {{-- Logout Button --}}
            <form action="{{ route('logout') }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="bg-[#A67D44] hover:bg-[#E2BB4D] text-white font-semibold py-2 md:py-3 px-6 md:px-8 text-base md:text-lg transition duration-300">
                    Logout
                </button>
            </form>

        </div>
    </div>

    {{-- Side Image --}}
    <div class="w-full lg:w-1/3 flex justify-center items-center mt-8 lg:mt-0">
        <img src="https://static.thenounproject.com/png/1594252-200.png" alt="Profile Illustration"
             class="shadow-2xl hidden lg:block w-40 h-40 md:w-60 md:h-60 lg:w-[350px] lg:h-[350px] object-cover border-4 border-[#A67D44]">
    </div>

</div>
@endsection
