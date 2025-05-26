@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-2xl md:max-w-3xl lg:max-w-6xl flex flex-col lg:flex-row items-center h-auto lg:h-screen flex-wrap mx-auto my-10 md:my-20 lg:my-0 relative px-2 md:px-6">
    <!--Main Col-->
    <div id="profile"
        class="w-full lg:w-2/3 shadow-2xl bg-[#65090D] opacity-95 mx-0 md:mx-4 lg:mx-0 border-4 border-[#A67D44] rounded-2xl">
        <div class="p-4 sm:p-8 md:p-10 lg:p-16 text-center lg:text-left">
            <!-- Image for mobile view-->
            <div class="block lg:hidden shadow-xl mx-auto -mt-16 md:-mt-20 h-32 w-32 md:h-40 md:w-40 bg-cover bg-center border-4 border-[#A67D44] rounded-full"
                style="background-image: url('https://www.freeiconspng.com/thumbs/profile-icon-png/account-profile-user-icon--icon-search-engine-10.png')"></div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold pt-6 md:pt-10 lg:pt-0 text-[#E2BB4D]">{{ $member->nama }}</h1>
            <div class="mx-auto lg:mx-0 w-4/5 pt-2 md:pt-4 border-b-2 border-[#E2BB4D] opacity-25"></div>
            <p class="pt-4 md:pt-6 text-base md:text-lg font-bold flex items-center justify-center lg:justify-start text-white">
                <svg class="h-5 fill-current text-[#E2BB4D] pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9 12H1v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-8v2H9v-2zm0-1H0V5c0-1.1.9-2 2-2h4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h4a2 2 0 0 1 2 2v6h-9V9H9v2zm3-8V2H8v1h4z"/></svg>
                Member
            </p>
            <p class="pt-2 md:pt-3 text-[#E2BB4D] text-sm md:text-base lg:text-lg flex items-center justify-center lg:justify-start">
                <svg class="h-5 fill-current text-[#E2BB4D] pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm7.75-8a8.01 8.01 0 0 0 0-4h-3.82a28.81 28.81 0 0 1 0 4h3.82zm-.82 2h-3.22a14.44 14.44 0 0 1-.95 3.51A8.03 8.03 0 0 0 16.93 14zm-8.85-2h3.84a24.61 24.61 0 0 0 0-4H8.08a24.61 24.61 0 0 0 0 4zm.25 2c.41 2.4 1.13 4 1.67 4s1.26-1.6 1.67-4H8.33zm-6.08-2h3.82a28.81 28.81 0 0 1 0-4H2.25a8.01 8.01 0 0 0 0 4zm.82 2a8.03 8.03 0 0 0 4.17 3.51c-.42-.96-.74-2.16-.95-3.51H3.07zm13.86-8a8.03 8.03 0 0 0-4.17-3.51c.42.96.74 2.16.95 3.51h3.22zm-8.6 0h3.34c-.41-2.4-1.13-4-1.67-4S8.74 3.6 8.33 6zM3.07 6h3.22c.2-1.35.53-2.55.95-3.51A8.03 8.03 0 0 0 3.07 6z"/></svg>
                {{ $member->email }}
            </p>
            <p class="pt-2 md:pt-3 text-white text-sm md:text-base lg:text-lg flex items-center justify-center lg:justify-start">
                <svg class="h-5 fill-current text-[#E2BB4D] pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12 24C5.385 24 0 18.615 0 12S5.385 0 12 0s12 5.385 12 12-5.385 12-12 12zm10.12-10.358c-.35-.11-3.17-.953-6.384-.438 1.34 3.684 1.887 6.684 1.992 7.308 2.3-1.555 3.936-4.02 4.395-6.87zm-6.115 7.808c-.153-.9-.75-4.032-2.19-7.77l-.066.02c-5.79 2.015-7.86 6.025-8.04 6.4 1.73 1.358 3.92 2.166 6.29 2.166 1.42 0 2.77-.29 4-.814zm-11.62-2.58c.232-.4 3.045-5.055 8.332-6.765.135-.045.27-.084.405-.12-.26-.585-.54-1.167-.832-1.74C7.17 11.775 2.206 11.71 1.756 11.7l-.004.312c0 2.633.998 5.037 2.634 6.855zm-2.42-8.955c.46.008 4.683.026 9.477-1.248-1.698-3.018-3.53-5.558-3.8-5.928-2.868 1.35-5.01 3.99-5.676 7.17zM9.6 2.052c.282.38 2.145 2.914 3.822 6 3.645-1.365 5.19-3.44 5.373-3.702-1.81-1.61-4.19-2.586-6.795-2.586-.825 0-1.63.1-2.4.285zm10.335 3.483c-.218.29-1.935 2.493-5.724 4.04.24.49.47.985.68 1.486.08.18.15.36.22.53 3.41-.43 6.8.26 7.14.33-.02-2.42-.88-4.64-2.31-6.38z"/></svg>
                {{ $member->no_hp }}
            </p>
            <p class="pt-2 md:pt-3 text-[#E2BB4D] text-sm md:text-base lg:text-lg flex items-center justify-center lg:justify-start">
                <svg class="h-5 fill-current text-[#E2BB4D] pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.5 6.75V0h9v6.75h-9zm9 3.75H24V24H0V10.5h7.5v6.75h9V10.5z"/></svg>
                {{ $member->tanggal_lahir->format('d-m-Y') }}
            </p>
            <div class="pt-8 md:pt-10 pb-8 md:pb-10 mt-4 text-center">
                <a href="{{ route('profile.edit') }}" class="bg-[#E2BB4D] hover:bg-yellow-600 text-[#65090D] font-bold py-2 md:py-3 px-6 md:px-8 rounded-full text-base md:text-lg transition">Edit Profil</a>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="bg-[#A67D44] hover:bg-[#E2BB4D] text-white font-semibold py-2 md:py-3 px-6 md:px-8 rounded-full text-base md:text-lg transition duration-300">Logout</button>
            </form>
        </div>
    </div>
    <!--Img Col-->
    <div class="w-full lg:w-1/3 flex justify-center items-center mt-8 lg:mt-0">
        <img src="https://static.thenounproject.com/png/1594252-200.png" class="shadow-2xl hidden lg:block w-40 h-40 md:w-60 md:h-60 lg:w-[350px] lg:h-[350px] object-cover border-4 border-[#A67D44] rounded-2xl">
    </div>
</div>
@endsection
