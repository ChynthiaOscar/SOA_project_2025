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
        <div onclick="openModal()" class="p-2 bg-[#EEEACB] border-2 border-[#65090D] w-64 cursor-pointer shadow-lg hover:shadow-2xl transition duration-300 align-items-center justify-center self-center align-self-center">
            <div class="px-8 py-1 border-2 border-dashed border-[#A67D44]">
                <h3 class="text-center text-xl font-bold text-[#65090D]">Add Category</h3>
                <svg class="justify-self-center mt-1 mb-2 mx-auto" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#65090D"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
            </div>
        </div>

        @include('pages.service-menu.partials.category-card', [
            'title' => 'Appetizer',
            'count' => '23'
        ])
    </div>
</div>

    {{-- MODAL --}}
    <div id="categoryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-[#65090D]">Add New Category</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-black">&times;</button>
            </div>
            <form id="categoryForm">
                <label class="block mb-2 text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="categoryName" name="categoryName" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4" placeholder="e.g., Dessert">
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#E2BB4D] text-[#65090D] rounded hover:bg-[#A67D44]">Add</button>
                </div>
            </form>
        </div>
    </div>

<script>
    function openModal() {
        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }

    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('categoryName').value;
        // console.log('Category Added:', name);
        this.reset();
        closeModal();
    });
</script>
@endsection
