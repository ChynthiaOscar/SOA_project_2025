@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#EEEACB] flex flex-col">

        {{-- header --}}
        <div class="bg-[#131313] text-[#E2BB4D] py-8 px-6 flex items-center">
            <h2 class="font-bold text-4xl">Create Menu Item</h2>
        </div>

        {{-- form (main content with grow to push footer down if any) --}}
        <div class="flex-grow">
            <div class="max-w-2xl mx-auto mt-10 mb-10 bg-[#E2BB4D] border-2 border-[#65090D] shadow-lg p-8">
                <form action="{{ route('add_recipe') }}" method="GET" enctype="multipart/form-data">
                    {{-- image --}}
                    <div class="mb-6">
                        <label for="image" class="block text-[#65090D] font-semibold text-lg mb-2">Image</label>
                        <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png"
                            class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] text-[#65090D] focus:outline-none focus:ring-2 focus:ring-[#65090D] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#65090D] file:text-white hover:file:bg-[#4e070a]" />
                    </div>
                    {{-- category name --}}
                    <div class="mb-6">
                        <label for="category" class="block text-[#65090D] font-semibold text-lg mb-2">Category Name</label>
                        <select id="ingredient" name="category_id"
                            class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] focus:outline-none focus:ring-2 focus:ring-[#65090D]">
                            <option value="" disabled selected style="color: #6B7280;">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- menu name --}}
                    <div class="mb-6">
                        <label for="name" class="block text-[#65090D] font-semibold text-lg mb-2">Menu Name</label>
                        <input type="text" id="name" name="name"
                            class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788]  focus:outline-none focus:ring-2 focus:ring-[#65090D]"
                            placeholder="e.g. Mongolian Beef">
                    </div>
                    {{-- description --}}
                    <div class="mb-6">
                        <label for="description" class="block text-[#65090D] font-semibold text-lg mb-2">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] focus:outline-none focus:ring-2 focus:ring-[#65090D] resize-y"
                            style="overflow: auto; scrollbar-width: none; -ms-overflow-style: none;" placeholder="Enter a short description..."></textarea>
                    </div>
                    {{-- price --}}
                    <div class="mb-6">
                        <label for="price" class="block text-[#65090D] font-semibold text-lg mb-2">Price (IDR)</label>
                        <input type="number" name="price" id="price" step="0.01"
                            class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788]  focus:outline-none focus:ring-2 focus:ring-[#65090D]"
                            placeholder="e.g. 175">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-[#65090D] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#4e070a] transition">
                            Add Recipe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
