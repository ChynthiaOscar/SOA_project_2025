@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#EEEACB] flex flex-col">

    {{-- header --}}
    <div class="bg-[#131313] text-[#E2BB4D] py-8 px-6 flex items-center">
        <h2 class="font-bold text-4xl">Edit Menu Item</h2>
    </div>

    {{-- form (main content with grow to push footer down if any) --}}
    <div class="flex-grow">
        <div class="max-w-2xl mx-auto mt-10 mb-10 bg-[#E2BB4D] border-2 border-[#65090D] shadow-lg p-8">
        <form>
            {{-- category name --}}
            <div class="mb-6">
                <label for="category" class="block text-[#65090D] font-semibold text-lg mb-2">Category Name</label>
                <select id="ingredient" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] focus:outline-none focus:ring-2 focus:ring-[#65090D]">
                    <option value="" disabled selected style="color: #6B7280;">Select a category</option>
                    <option value="garlic">Appetizer</option>
                    <option value="onion">Soup</option>
                    <option value="chicken">Main Course</option>
                    <option value="beef">Dessert</option>
                    <option value="rice">Beverages</option>
                </select>
            </div>
            {{-- menu name --}}
            <div class="mb-6">
                <label for="name" class="block text-[#65090D] font-semibold text-lg mb-2">Menu Name</label>
                <input type="text" id="name" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788]  focus:outline-none focus:ring-2 focus:ring-[#65090D]" placeholder="e.g. Mongolian Beef">
            </div>
            {{-- description --}}
            <div class="mb-6">
                <label for="description" class="block text-[#65090D] font-semibold text-lg mb-2">Description</label>
                <textarea id="description" rows="4" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] focus:outline-none focus:ring-2 focus:ring-[#65090D] resize-y" style="overflow: auto; scrollbar-width: none; -ms-overflow-style: none;" placeholder="Enter a short description..."></textarea>
            </div>
            {{-- price --}}
            <div class="mb-6">
                <label for="price" class="block text-[#65090D] font-semibold text-lg mb-2">Price (IDR)</label>
                <input type="number" id="price" step="0.01" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788]  focus:outline-none focus:ring-2 focus:ring-[#65090D]" placeholder="e.g. 175">
            </div>

            <div class="flex justify-end">
                <a href="{{ url('/edit_recipe') }}" title="Add Recipe">
                <button type="button" class="bg-[#65090D] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#4e070a] transition">
                    Edit Recipe
                </button>
                </a>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
