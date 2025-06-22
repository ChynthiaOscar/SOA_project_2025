@extends('layouts.app')

@section('title', 'Add New Inventory Item')

@section('content')
<div class="container mx-auto p-4 md:p-8">
    <div class="bg-[#FDF2D0] shadow-xl rounded-lg p-6 md:p-8 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-black mb-6 text-center">Add New Inventory Item</h2>
        <form action="{{ route('inventory.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="inventoryItem_name" class="block text-sm font-medium text-black">Name</label>
                <input type="text" name="inventoryItem_name" id="inventoryItem_name" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required>
            </div>
            <div>
                <label for="inventoryItem_description" class="block text-sm font-medium text-black">Description</label>
                <textarea name="inventoryItem_description" id="inventoryItem_description" rows="3" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="inventoryItem_currentQuantity" class="block text-sm font-medium text-black">Current Quantity</label>
                    <input type="number" step="0.01" name="inventoryItem_currentQuantity" id="inventoryItem_currentQuantity" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required>
                </div>
                <div>
                    <label for="inventoryItem_unitOfMeasure" class="block text-sm font-medium text-black">Unit of Measure</label>
                    <input type="text" name="inventoryItem_unitOfMeasure" id="inventoryItem_unitOfMeasure" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="inventoryItem_reorderPoint" class="block text-sm font-medium text-black">Reorder Point</label>
                    <input type="number" step="0.01" name="inventoryItem_reorderPoint" id="inventoryItem_reorderPoint" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required>
                </div>
                <div>
                    <label for="inventoryItem_initialStockLevel" class="block text-sm font-medium text-black">Initial Stock Level</label>
                    <input type="number" step="0.01" name="inventoryItem_initialStockLevel" id="inventoryItem_initialStockLevel" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required>
                </div>
            </div>
            <div>
                <label for="inventoryItem_lastUpdated" class="block text-sm font-medium text-black">Last Updated</label>
                <input type="date" name="inventoryItem_lastUpdated" id="inventoryItem_lastUpdated" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required>
            </div>
            <div>
                <label for="inventoryCategory_inventoryCategory_id" class="block text-sm font-medium text-black">Category</label>
                <select name="inventoryCategory_inventoryCategory_id" id="inventoryCategory_inventoryCategory_id" class="mt-1 block w-full bg-white border border-[#A88A29] rounded-md shadow-sm py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->inventoryCategory_id }}">{{ $category->inventoryCategory_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#A88A29] hover:bg-[#7D661C] text-black font-semibold py-2 px-6 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#A88A29] focus:ring-offset-[#FDF2D0]">Add Item</button>
            </div>
        </form>
    </div>
</div>
@endsection