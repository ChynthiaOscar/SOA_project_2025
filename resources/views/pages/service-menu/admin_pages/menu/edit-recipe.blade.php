@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#EEEACB]">

    <div class="bg-[#131313] text-[#E2BB4D] py-8 px-6 flex items-center">
        <h2 class="font-bold text-4xl">Edit Recipe</h2>
    </div>


    <div class="mx-auto px-4 md:px-12 lg:px-20 py-8">
        <form action="{{ route('store.menu') }}" method="POST" enctype="multipart/form-data">
                @csrf
        <div class="flex flex-col md:flex-row gap-20 items-start">
            <div class="bg-[#E2BB4D] border-2 border-[#65090D] shadow-lg p-6 flex-1 self-start">
                <h3 class="text-2xl font-bold text-[#65090D] mb-6 text-center">Menu Name</h3>
                    <div class="mb-6">
                        <div class="flex gap-4 mb-4">
                            {{-- ingredient name --}}
                            <div class="flex-1">
                                <label for="ingredient" class="block text-[#65090D] font-semibold text-lg mb-2">Ingredient Name</label>
                                <div class="relative">
                                    <input type="text" id="ingredientSearch" placeholder="Search ingredient..." autocomplete="off"
                                        class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] focus:outline-none focus:ring-2 focus:ring-[#65090D] rounded">
                                    <ul id="ingredientList" class="absolute z-10 mt-1 w-full bg-[#FFF7DA] border border-[#65090D] rounded shadow-lg hidden max-h-60 overflow-auto">
                                        @php
                                                $ingredients = [
                                                    ['id' => 1, 'name' => 'Garlic'],
                                                    ['id' => 2, 'name' => 'Beef'],
                                                    ['id' => 3, 'name' => 'Soy Sauce'],
                                                    ['id' => 4, 'name' => 'Bao Bun'],
                                                    ['id' => 5, 'name' => 'Pork Belly'],
                                                    ['id' => 6, 'name' => 'Carrot'],
                                                    ['id' => 7, 'name' => 'Rice Noodle'],
                                                    ['id' => 8, 'name' => 'Wonton Skin'],
                                                    ['id' => 9, 'name' => 'Noodles'],
                                                    ['id' => 10, 'name' => 'Rice'],
                                                    ['id' => 11, 'name' => 'Corn'],
                                                    ['id' => 12, 'name' => 'Tea Leaves'],
                                                    ['id' => 13, 'name' => 'Cucumber'],
                                                    ['id' => 14, 'name' => 'Mantou Bun'],
                                                    ['id' => 15, 'name' => 'Baijiu'],
                                                    ['id' => 16, 'name' => 'Cabernet Franc'],
                                                    ['id' => 17, 'name' => 'Condensed Milk'],
                                                    ['id' => 18, 'name' => 'Chicken'],
                                                    ['id' => 19, 'name' => 'Tofu'],
                                                    ['id' => 20, 'name' => 'Red Bean Paste'],
                                                    ['id' => 21, 'name' => 'Sesame Seeds'],
                                                    ['id' => 22, 'name' => 'Scallion'],
                                                    ['id' => 23, 'name' => 'Lotus Root'],
                                                    ['id' => 24, 'name' => 'Fish Fillet'],
                                                    ['id' => 25, 'name' => 'Tomato'],
                                                    ['id' => 26, 'name' => 'Egg'],
                                                    ['id' => 27, 'name' => 'Mushroom'],
                                                    ['id' => 28, 'name' => 'Chili Sauce'],
                                                ];
                                            @endphp
                                    @foreach ($ingredients as $ingredient)
                                                <li class="px-4 py-2 cursor-pointer hover:bg-[#E2BB4D]"
                                                    data-value="{{ $ingredient['id'] }}">
                                                    {{ $ingredient['name'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <input type="hidden" id="ingredient">
                                    </div>


                            </div>

                            {{-- amount --}}
                            <div class="w-32">
                                <label for="amount1" class="block text-[#65090D] font-semibold text-lg mb-2">Amount</label>
                                <input type="text" id="amount1" class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] focus:outline-none focus:ring-2 focus:ring-[#65090D]" placeholder="e.g. 2g">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="button" class="bg-[#65090D] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#4e070a] transition">
                            Add Ingredient
                        </button>
                    </div>
            </div>

            <div class="flex-1 flex flex-col">

                <div class="bg-white border-2 border-[#65090D] overflow-hidden shadow-md">
    <div class="overflow-hidden">
        <table class="min-w-full text-left">
            <thead class="bg-[#65090D] text-white">
                <tr>
                    <th class="px-6 py-3">Ingredient</th>
                    <th class="px-6 py-3">Amount</th>
                </tr>
            </thead>
        </table>

        <div style="max-height: 18rem; overflow-y: auto;">
                                    <table class="min-w-full text-left">
                                        <tbody class="text-[#65090D]" id="cartTableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="list_ingredient" id="list_ingredient">
                        <input type="hidden" name="image" value="{{ $image }}">
                        <input type="hidden" name="name" value="{{ $name }}">
                        <input type="hidden" name="description" value="{{ $description }}">
                        <input type="hidden" name="price" value="{{ $price }}">
                        <input type="hidden" name="category_id" value="{{ $category_id }}">
                        <div class="mt-6 self-end">
                            <button type="submit"
                                class="bg-[#65090D] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#4e070a] transition">
                                Add Menu
                            </button>
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- delete modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md border-2 border-[#65090D]">
        <div class="p-6 text-center">
            <h3 class="text-xl font-bold text-[#65090D] mb-4">Delete Ingredient</h3>
            <p class="text-gray-700 mb-6">Are you sure you want to delete <span id="ingredientToDelete" class="font-semibold"></span> from the list?</p>
            <div class="flex justify-center gap-4">
                <button onclick="closeDeleteModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">Cancel</button>
                <button onclick="confirmDelete()" class="bg-[#65090D] hover:bg-[#4e070a] text-white font-semibold py-2 px-4 rounded-lg transition">Delete</button>
            </div>
        </div>
    </div>
</div>

{{-- edit modal --}}
<div id="editModal" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden">
    <div class="bg-[#EEEACB] shadow-lg w-full max-w-md border-2 border-[#65090D]">
        <div class="p-6 text-center">
            <h3 class="text-xl font-bold text-[#65090D] mb-4">
                Edit <span id="ingredientToEdit" class="text-[#65090D]"></span>
            </h3>
            <div class="mb-6">
                <label for="newAmount" class="block text-left font-semibold text-[#65090D] mb-2">Amount</label>
                <input type="text" id="newAmount" class="w-full px-4 py-2 border border-[#65090D] bg-[#E4C788] rounded focus:outline-none focus:ring-2 focus:ring-[#65090D]">
            </div>
            <div class="flex justify-center gap-4">
                <button onclick="closeEditModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">Cancel</button>
                <button onclick="confirmEdit()" class="bg-[#65090D] hover:bg-[#4e070a] text-white font-semibold py-2 px-4 rounded-lg transition">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    // delete modal
    let ingredientToDelete = '';
    let deleteRowElement = null;

    function openDeleteModal(ingredientName, rowElement) {
        ingredientToDelete = ingredientName;
        deleteRowElement = rowElement;
        document.getElementById('ingredientToDelete').textContent = ingredientName;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        ingredientToDelete = '';
        deleteRowElement = null;
    }

    function confirmDelete() {
        if (deleteRowElement) {
            deleteRowElement.remove();
        }
        closeDeleteModal();
    }

    // edit modal
    let currentEditRow = null;
    let currentEditAmountSpan = null;

    function openEditModal(ingredientName, rowElement) {
        currentEditRow = rowElement;
        currentEditAmountSpan = rowElement.querySelector('span');

        document.getElementById('ingredientToEdit').textContent = ingredientName;
        document.getElementById('newAmount').value = currentEditAmountSpan.textContent.trim();

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        currentEditRow = null;
        currentEditAmountSpan = null;
    }

    function confirmEdit() {
        const newAmount = document.getElementById('newAmount').value.trim();
        if (newAmount && currentEditAmountSpan) {
            currentEditAmountSpan.textContent = newAmount;
        }
        closeEditModal();
    }

    // searchable ingredients
    const ingredientSearch = document.getElementById('ingredientSearch');
    const ingredientList = document.getElementById('ingredientList');
    const ingredientInput = document.getElementById('ingredient');

    ingredientSearch.addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const items = ingredientList.querySelectorAll('li');
        let hasMatch = false;

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            const match = text.includes(filter);
            item.style.display = match ? 'block' : 'none';
            if (match) hasMatch = true;
        });

        ingredientList.classList.toggle('hidden', !hasMatch);
    });

    ingredientSearch.addEventListener('focus', () => {
        ingredientList.classList.remove('hidden');
    });

    document.addEventListener('click', function (e) {
        if (!ingredientSearch.parentNode.contains(e.target)) {
            ingredientList.classList.add('hidden');
        }
    });

    ingredientList.querySelectorAll('li').forEach(item => {
        item.addEventListener('click', function () {
            ingredientSearch.value = this.textContent;
            ingredientInput.value = this.dataset.value;
            ingredientList.classList.add('hidden');
        });
    });
</script>

@endsection
