@extends('layouts.app')

@section('title', 'Inventory Items')

@section('content')

 <body> 

<div class="container mx-auto p-4 md:p-8">
    <div class="bg-[#FDF2D0] shadow-xl rounded-lg overflow-hidden">
        <!-- Warning Section -->
        @php
            $lowStockItems = $inventoryItems->filter(function($item) {
                return $item->inventoryItem_currentQuantity < $item->inventoryItem_reorderPoint;
            });
        @endphp
        @if($lowStockItems->count())
        <div class="bg-[#FCD772] border-l-4 border-[#F53939] text-black p-4 mb-6 rounded flex items-center">
            <i class="fas fa-exclamation-triangle mr-3 text-[#BA1E1E] text-2xl"></i>
            <div>
                <div class="font-bold mb-1">Warning: Low Stock Items</div>
                <ul class="list-disc pl-5">
                    @foreach($lowStockItems as $item)
                        <li>
                            <span class="font-semibold">{{ $item->inventoryItem_name }}</span>
                            (Current: <span class="text-[#BA1E1E] font-bold">{{ $item->inventoryItem_currentQuantity }}</span>,
                            Reorder Point: {{ $item->inventoryItem_reorderPoint }})
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        
        <!-- Header Section -->
        <header class="px-6 py-5 border-b border-[#E0C98F]">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-semibold text-black">
                        Products
                        <span class="ml-2 text-xs font-bold text-white bg-[#BA1E1E] px-2 py-1 rounded-full align-middle">
                            {{ count($inventoryItems) }}
                        </span>
                    </h1>
                    <nav class="ml-10 space-x-6">
                        <a href="#" class="text-[#BA1E1E] border-b-2 border-[#BA1E1E] pb-1 font-semibold">All</a>
                        <a href="{{ route('service-inventory.category') }}" class="text-gray-700 hover:text-[#BA1E1E]">Categories</a>
                    </nav>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-gray-500"></i>
                        </span>
                        <input type="text" id="searchInput" placeholder="Search" class="w-full py-2 pl-10 pr-4 text-sm text-black bg-white border border-[#A88A29] rounded-full focus:outline-none focus:ring-2 focus:ring-[#A88A29] focus:border-transparent">
                    </div>
                    <button onclick="window.location='{{ route('inventory.create') }}'" class="bg-[#A88A29] hover:bg-[#7D661C] text-black font-semibold py-2 px-5 rounded-full text-sm flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add new item
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="flex flex-col md:flex-row md:space-x-6 p-6">
            <!-- Table Section -->
            <div class="w-full md:flex-grow overflow-x-auto">
                <table class="min-w-full bg-white ">
                    <thead class="bg-[#D4AF37]">
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Item ID</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Name</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Description</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Category</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Current Qty</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Unit</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Reorder Pt.</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Initial Stock</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Last Updated</th>
                            <th class="px-5 py-3 border-b-2 border-[#E0C98F] text-left text-xs font-semibold text-black uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        @forelse ($inventoryItems as $item)
                        <tr class="hover:bg-yellow-50">
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-gray-700">{{ $item->inventoryItem_id }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-black font-medium item-name">{{ $item->inventoryItem_name }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-gray-600 truncate max-w-xs">{{ $item->inventoryItem_description }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-gray-700">{{ $item->category->inventoryCategory_name ?? 'N/A' }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-gray-700 text-right">{{ $item->inventoryItem_currentQuantity }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-gray-700">{{ $item->inventoryItem_unitOfMeasure }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-gray-700 text-right">{{ $item->inventoryItem_reorderPoint }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-gray-700 text-right">{{ $item->inventoryItem_initialStockLevel }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-gray-700">{{ \Carbon\Carbon::parse($item->inventoryItem_lastUpdated)->format('M d, Y') }}</td>
                            <td class="px-5 py-4 border-b border-[#E0C98F] text-sm text-center">
                                <div class="relative inline-block text-left">
                                    <button type="button" class="inline-flex justify-center w-full rounded-md px-2 py-1 text-sm font-medium text-gray-600 hover:text-black focus:outline-none" onclick="toggleDropdown(this)">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-10 action-dropdown">
                                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                            <a href="{{ route('inventory.edit', $item->inventoryItem_id) }}" class="block px-4 py-2 text-sm text-black hover:bg-yellow-100 hover:text-black flex items-center" role="menuitem">
                                                <i class="fas fa-edit w-5 mr-2 text-gray-500"></i> Edit
                                            </a>
                                            <form action="{{ route('inventory.destroy', $item->inventoryItem_id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-[#BA1E1E] hover:bg-red-50 hover:text-[#7D1111] flex items-center" role="menuitem">
                                                    <i class="fas fa-trash-alt w-5 mr-2 text-[#F53939]"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-5 py-10 border-b border-[#E0C98F] text-center text-sm text-gray-500">
                                No inventory items found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Sidebar Section -->
            <aside class="w-full md:w-80 lg:w-96 mt-6 md:mt-0 md:flex-shrink-0 bg-[#7D1111] p-6 rounded-lg border border-[#450505]">
                <h2 class="text-lg font-semibold text-[#FDEDED] mb-5">Products category</h2>

                @php
                    $categories = App\Models\InventoryCategory::all();
                    $categoryColors = ['#F53939', '#D4AF37', '#434343', '#BA1E1E', '#FCD772', '#A88A29', '#450505', '#FAC2C2'];
                    $categoryCounts = [];
                    $totalItems = 0;
                    foreach ($categories as $i => $category) {
                        $count = \App\Models\InventoryItem::where('inventoryCategory_inventoryCategory_id', $category->inventoryCategory_id)->count();
                        $categoryCounts[] = [
                            'name' => $category->inventoryCategory_name,
                            'count' => $count,
                            'color' => $categoryColors[$i % count($categoryColors)]
                        ];
                        $totalItems += $count;
                    }
                @endphp
                <div class="mb-8 flex justify-center">
                    <div class="donut-chart relative">
                        <svg width="150" height="150" viewBox="0 0 42 42">
                            @php
                                $circumference = 2 * pi() * 16;
                                $offset = 0;
                            @endphp
                            @foreach($categoryCounts as $i => $cat)
                                @php
                                    $percent = $totalItems > 0 ? ($cat['count'] / $totalItems) : 0;
                                    $length = $percent * $circumference;
                                @endphp
                                <circle
                                    r="16" cx="21" cy="21"
                                    fill="transparent"
                                    stroke="{{ $cat['color'] }}"
                                    stroke-width="6"
                                    stroke-dasharray="{{ $length }} {{ $circumference - $length }}"
                                    stroke-dashoffset="{{ -$offset }}"
                                />
                                @php $offset += $length; @endphp
                            @endforeach
                        </svg>
                        <div class="donut-chart-hole absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#7D1111] text-[#FDEDED]">
                            {{ $totalItems }}
                        </div>
                    </div>
                </div>

                <ul class="space-y-3">
                    @foreach ($categoryCounts as $cat)
                    <li class="flex justify-between items-center text-sm">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $cat['color'] }}"></span>
                            <span class="text-[#FDEDED]">{{ $cat['name'] }}</span>
                        </div>
                        <span class="text-[#FAC2C2] font-medium">
                            {{ $cat['count'] }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </aside>
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
   
    .donut-chart {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .donut-chart-hole {
        width: 70%;
        height: 70%;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleDropdown(buttonElement) {
        const dropdown = buttonElement.nextElementSibling;
        document.querySelectorAll('.action-dropdown.block').forEach(openDropdown => {
            if (openDropdown !== dropdown) {
                openDropdown.classList.add('hidden');
                openDropdown.classList.remove('block');
            }
        });
        dropdown.classList.toggle('hidden');
        dropdown.classList.toggle('block');
    }

    window.onclick = function(event) {
        if (!event.target.matches('.fa-ellipsis-h') && !event.target.closest('.action-dropdown')) {
            document.querySelectorAll('.action-dropdown.block').forEach(openDropdown => {
                openDropdown.classList.add('hidden');
                openDropdown.classList.remove('block');
            });
        }
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('#inventoryTableBody tr').forEach(function(row) {
            const name = row.querySelector('.item-name')?.textContent.toLowerCase() || '';
            row.style.display = (search === '' || name.includes(search)) ? '' : 'none';
        });
    });
</script>
@endpush