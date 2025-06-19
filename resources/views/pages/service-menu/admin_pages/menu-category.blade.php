@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#EEEACB]">

    {{-- header --}}
    <div class="bg-[#131313] text-[#E2BB4D] py-8 px-6 flex items-center">
        <h2 class="font-bold text-4xl">Menu Category</h2>
    </div>

    {{-- content --}}
    <div class="grid grid-cols-4 gap-y-6 gap-x-2 p-12 justify-items-center">
        {{-- add Category --}}
        <div class="p-2 bg-[#EEEACB] border-2 border-[#65090D] w-64 cursor-pointer shadow-lg hover:shadow-2xl transition duration-300 align-items-center justify-center self-center align-self-center">
            <div class="px-8 py-1 border-2 border-dashed border-[#A67D44]">
                <h3 class="text-center text-xl font-bold text-[#65090D]">Add Category</h3>
                <svg class="justify-self-center mt-1 mb-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#65090D"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
            </div>
        </div>
        @include('pages.service-menu.partials.category-card', [
            'title' => 'Appetizer',
            'count' => '23'
        ])
        @include('pages.service-menu.partials.category-card', [
            'title' => 'Soup',
            'count' => '16'
        ])
        @include('pages.service-menu.partials.category-card', [
            'title' => 'Main Course',
            'count' => '45'
        ])
        @include('pages.service-menu.partials.category-card', [
            'title' => 'Dessert',
            'count' => '12'
        ])
        @include('pages.service-menu.partials.category-card', [
            'title' => 'Beverages',
            'count' => '23'
        ])

    </div>

</div>
@endsection