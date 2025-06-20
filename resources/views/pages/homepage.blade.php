
@extends('layouts.app')

@section('title', 'HomePage')

@section('content')
{{-- BANNER --}}
<section class="relative h-[80vh] w-full overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('images/homepage/banner.jpg') }}" alt="Banner" class="w-full h-full object-cover blur-sm scale-105">
        <div class="absolute inset-0 bg-black bg-opacity-70"></div>
    </div>
    <div class="relative z-10 h-full flex items-center justify-center text-center px-6">
        <div class="text-white max-w-3xl">
            <h1 class="font-serif text-4xl font-bold mb-4 text-white">
                WELCOME TO 
                <span class="text-[#E2BB4D] drop-shadow-[0_0_10px_rgba(226,187,77,0.6)]">
                    YÙ JADE
                </span>
            </h1>

            <p class="text-xl italic">A Taste of Timeless Elegance</p>
        </div>
    </div>
</section>


{{-- OUR MENU --}}
<section class="bg-black py-16 px-4 sm:px-6 lg:px-8">

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- KIRI -->
        <div class="flex flex-col space-y-6">
            <div class="bg-white overflow-hidden shadow-md">
                <div class="relative h-full">
                    <img src="{{ asset('images/homepage/homepage_bao_bun.png') }}" alt="bao buns" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md">
                <div class="relative h-full">
                    <img src="{{ asset('images/homepage/homepage_braised_pork.png') }}" alt="braised pork belly" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                <div class="relative h-full">
                    <img src="{{ asset('images/homepage/homepage_oolong_tea.png') }}" alt="oolong tea set" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- KANAN -->
        <div class="flex flex-col space-y-6">
            <div class="bg-white overflow-hidden shadow-md">
                <div class="relative h-full">
                    <img src="{{ asset('images/homepage/homepage_dimsum.png') }}" alt="dimsum" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md">
                <div class="relative h-full">
                    <img src="{{ asset('images/homepage/homepage_sichuan_fish.png') }}" alt="sichuan fish" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md">
                <div class="relative h-full">
                    <img src="{{ asset('images/homepage/homepage_congee.png') }}" alt="congee" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md">
                <div class="relative h-full">
                    <img src="{{ asset('images/homepage/homepage_tofu_pudding.png') }}" alt="tofu pudding" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

    </div>
</section>


{{-- CONTACT --}}
{{-- <section class="bg-black py-16 px-6 text-white">
    <div class="max-w-3xl mx-auto text-center space-y-6">
        <h2 class="text-4xl font-semibold tracking-wide uppercase text-[#E2BB4D]">Contact Us</h2>
        <div class="text-lg leading-relaxed space-y-2">
            <p class="text-gray-300">Address: 123 Chinatown, Surabaya</p>
            <p class="text-gray-300">Phone: +62 812 3456 7890</p>
            <p class="text-gray-300">Email: contact@yujade.com</p>
        </div>
    </div>
</section> --}}
@endsection
