@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#EEEACB]">

    {{-- header --}}
    <div class="bg-[#131313] text-[#E2BB4D] py-8 px-6 flex items-center">
        <h2 class="font-bold text-4xl">Add Recipe</h2>
    </div>

    {{-- form --}}
<div class="max-w-2xl mx-auto mt-10 bg-[#E2BB4D] border-2 border-[#65090D] shadow-lg p-8">
    <h3 class="text-2xl font-bold text-[#65090D] mb-6 text-center">Menu Name</h3>

    <form>
    <div class="mb-6">
        <div class="flex gap-4 mb-4">
            {{-- ingredient name --}}
            <div class="flex-1">
                <label for="ingredient1" class="block text-[#65090D] font-semibold text-lg mb-2">Ingredient Name</label>
                <input type="text" id="ingredient1" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#65090D]" placeholder="e.g. Garlic">
            </div>
            {{-- amount --}}
            <div class="w-32">
                <label for="amount1" class="block text-[#65090D] font-semibold text-lg mb-2">Amount</label>
                <input type="text" id="amount1" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#65090D]" placeholder="e.g. 2g">
            </div>
        </div>

        <div class="flex gap-4 items-start relative">
            {{-- ingredient name --}}
            <div class="flex-1">
                <label for="ingredient2" class="block text-[#65090D] font-semibold text-lg mb-2">Ingredient Name</label>
                <input type="text" id="ingredient2" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#65090D]" placeholder="e.g. Onion">
            </div>
            {{-- Aaount --}}
            <div class="w-32">
                <label for="amount2" class="block text-[#65090D] font-semibold text-lg mb-2">Amount</label>
                <input type="text" id="amount2" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#65090D]" placeholder="e.g. 5g">
            </div>
            <button type="button" class="absolute top-0 right-0 mt-1" title="Remove Row">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                    <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="flex justify-between items-center mt-6">
        <button type="button" class="bg-[#65090D] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#4e070a] transition">
            Add Ingredient
        </button>
        <button type="submit" class="bg-[#65090D] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#4e070a] transition">
            Edit Menu
        </button>
    </div>
</form>

</div>


    </div>

</div>
@endsection
