@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#131313] pt-48">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-4 gap-6">
            @include('pages.service-menu.partials.menu-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'title' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
            @include('pages.service-menu.partials.menu-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'title' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
            @include('pages.service-menu.partials.menu-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'title' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
            @include('pages.service-menu.partials.menu-card', [
                'image' => asset('images/service-menu/mongolian-beef.png'),
                'title' => 'Mongolian Beef',
                'description' => 'a sweet and savory stir-fry with tender beef and a rich soy-based sauce',
                'price' => '175'
            ])
        </div>
    </div>
</div>
@endsection
