@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#EEEACB] pt-32">
    
    {{-- header --}}
    <div class="bg-[#131313] text-[#E2BB4D] py-8 px-6 flex items-center">
        <h2 class="font-bold text-4xl">Menu List</h2>
    </div>

    {{-- content container with padding and max-width --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- grid for menu cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-8">
            @include('pages.service-menu.partials.menu-admin-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'name' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
            @include('pages.service-menu.partials.menu-admin-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'name' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
            @include('pages.service-menu.partials.menu-admin-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'name' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
            @include('pages.service-menu.partials.menu-admin-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'name' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
            @include('pages.service-menu.partials.menu-admin-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'name' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
        </div>
    </div>

    {{-- floating add button --}}
    <a href="{{ url('/add_menu') }}" class="fixed bottom-6 right-6 bg-[#65090D] text-white hover:bg-[#8b121b] shadow-lg rounded-full p-4 flex items-center justify-center transition duration-300" title="Add Menu">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
    </a>

</div>
@endsection
