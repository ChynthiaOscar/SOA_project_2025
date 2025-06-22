@extends('layouts.app')

@section('title', 'Items by Category')

@section('content')

<div class="container mx-auto p-4 md:p-8">
    <div class="bg-[#FDF2D0] shadow-xl rounded-lg overflow-hidden">
        
        <!-- Header Section -->
        <header class="px-6 py-5 border-b border-[#E0C98F]">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-semibold text-black">
                        Items by Category
                    </h1>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('categories.create') }}" class="bg-[#A88A29] hover:bg-[#7D661C] text-black font-semibold py-2 px-5 rounded-full text-sm flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Category
                    </a>
                    <a href="{{ route('inventory.index') }}" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-5 rounded-full text-sm flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to All Products
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content: Categories and Items List -->
        <div class="p-6 md:p-8">
            @if($categories->count() > 0)
                @foreach ($categories as $category)
                    <div class="mb-8 p-6 bg-white shadow-md rounded-lg border border-[#E0C98F]">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-[#BA1E1E] pb-2 border-b border-[#E0C98F]">
                                {{ $category->inventoryCategory_name }}
                                @if($category->items->count() > 0)
                                <span class="ml-2 text-xs font-semibold text-black bg-[#D4AF37] px-2 py-1 rounded-full align-middle">
                                    {{ $category->items->count() }} item(s)
                                </span>
                                @endif
                            </h2>
                            <div class="flex gap-2">
                                <a href="{{ route('categories.edit', $category->inventoryCategory_id) }}" class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-1 px-3 rounded-full flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category->inventoryCategory_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-100 hover:bg-red-200 text-red-800 font-semibold py-1 px-3 rounded-full flex items-center">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @if($category->items->count() > 0)
                            <ul class="space-y-3">
                                @foreach ($category->items as $item)
                                    <li class="p-3 bg-yellow-50 rounded-md border border-yellow-200 hover:shadow-lg transition-shadow duration-200">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="font-semibold text-black text-md">{{ $item->inventoryItem_name }}</span>
                                                @if($item->inventoryItem_description)
                                                <p class="text-sm text-gray-600 truncate max-w-md" title="{{ $item->inventoryItem_description }}">{{ Str::limit($item->inventoryItem_description, 70) }}</p>
                                                @endif
                                            </div>
                                            <div class="text-right flex-shrink-0 ml-4">
                                                <span class="text-sm text-gray-700 block">Qty: <span class="font-bold text-black">{{ $item->inventoryItem_currentQuantity }}</span> {{ $item->inventoryItem_unitOfMeasure }}</span>
                                                <a href="{{ route('inventory.edit', $item->inventoryItem_id) }}" class="text-xs text-[#7D1111] hover:text-[#450505] hover:underline font-semibold">
                                                    View/Edit
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600">No items found in this category.</p>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-10">
                    <i class="fas fa-folder-open fa-3x text-gray-400 mb-3"></i>
                    <p class="text-gray-600 text-lg">No categories with items to display.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #FDF2D0; 
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        background: #A88A29; 
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #7D661C; 
    }
</style>
@endpush