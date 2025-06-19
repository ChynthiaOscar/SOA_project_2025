@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#EEEACB]">

        {{-- header --}}
        <div class="bg-[#131313] text-[#E2BB4D] py-8 px-6 flex items-center">
            <h2 class="font-bold text-4xl">Menu List</h2>
        </div>

        {{-- list content --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8">
            @foreach ($menus as $menu)
                @include('pages.service-menu.partials.menu-admin-card', [
                    'id' => $menu['id'],
                    'image' => asset('images/service-menu/mongolian-beef.png'),
                    'name' => $menu['name'],
                    'description' => $menu['description'],
                    'price' => $menu['price'],
                ])
            @endforeach
        </div>

        <a href="{{ route('add_menu') }}"
            class="fixed bottom-6 right-6 bg-[#65090D] text-white hover:bg-[#8b121b] shadow-lg rounded-full p-4 flex items-center justify-center transition duration-300"
            title="Add Menu">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#E2BB4D">
                <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
            </svg>
        </a>


    </div>
@endsection
