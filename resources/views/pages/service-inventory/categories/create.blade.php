@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="container mx-auto p-4 md:p-8">
    <div class="bg-[#FDF2D0] shadow-xl rounded-lg p-6 md:p-8 max-w-xl mx-auto">
        <h2 class="text-2xl font-bold text-black mb-6 text-center">Add New Category</h2>
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="inventoryCategory_name" class="block text-sm font-medium text-black">Name</label>
                <input type="text" name="inventoryCategory_name" id="inventoryCategory_name" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required>
            </div>
            <div>
                <label for="inventoryCategory_description" class="block text-sm font-medium text-black">Description</label>
                <textarea name="inventoryCategory_description" id="inventoryCategory_description" rows="3" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required></textarea>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#A88A29] hover:bg-[#7D661C] text-black font-semibold py-2 px-5 rounded-full text-sm flex items-center">
                    <i class="fas fa-save mr-2"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
