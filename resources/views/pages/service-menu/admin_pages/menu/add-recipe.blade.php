@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#EEEACB]">

    <div class="bg-[#131313] text-[#E2BB4D] py-8 px-6 flex items-center">
        <h2 class="font-bold text-4xl">Add Recipe</h2>
    </div>


    <div class="mx-auto px-4 md:px-12 lg:px-20 py-8">
        <div class="flex flex-col md:flex-row gap-20 items-start">
            <div class="bg-[#E2BB4D] border-2 border-[#65090D] shadow-lg p-6 flex-1 self-start">
                <h3 class="text-2xl font-bold text-[#65090D] mb-6 text-center">Menu Name</h3>

                <form>
                    <div class="mb-6">
                        <div class="flex gap-4 mb-4">
                            {{-- ingredient name --}}
                            <div class="flex-1">
                                <label for="ingredient" class="block text-[#65090D] font-semibold text-lg mb-2">Ingredient Name</label>
                                <div class="relative">
    <input type="text" id="ingredientSearch" placeholder="Search ingredient..." autocomplete="off"
        class="w-full px-4 py-3 border border-[#E2BB4D] bg-[#E4C788] focus:outline-none focus:ring-2 focus:ring-[#65090D] rounded">
    <ul id="ingredientList" class="absolute z-10 mt-1 w-full bg-[#FFF7DA] border border-[#65090D] rounded shadow-lg hidden max-h-60 overflow-auto">
        <li class="px-4 py-2 cursor-pointer hover:bg-[#E2BB4D]" data-value="garlic">Garlic</li>
        <li class="px-4 py-2 cursor-pointer hover:bg-[#E2BB4D]" data-value="onion">Onion</li>
        <li class="px-4 py-2 cursor-pointer hover:bg-[#E2BB4D]" data-value="chicken">Chicken</li>
        <li class="px-4 py-2 cursor-pointer hover:bg-[#E2BB4D]" data-value="beef">Beef</li>
        <li class="px-4 py-2 cursor-pointer hover:bg-[#E2BB4D]" data-value="rice">Rice</li>
    </ul>
    <input type="hidden" id="ingredient" name="ingredient">
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
                </form>
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
                <tbody class="text-[#65090D]">
                    @php
                        $ingredients = [
                            ['name' => 'Garlic', 'amount' => '2g'],
                            ['name' => 'Onion', 'amount' => '5g'],
                            ['name' => 'Chicken', 'amount' => '150g'],
                            ['name' => 'Rice', 'amount' => '300g'],
                            ['name' => 'Scallions', 'amount' => '5g'],
                            ['name' => 'Pepper', 'amount' => '1g'],
                            ['name' => 'Salt', 'amount' => '1g'],
                            ['name' => 'Chilis', 'amount' => '20g'],
                        ];
                    @endphp

                    @foreach ($ingredients as $ingredient)
                    <tr class="border-t border-[#65090D]/40 bg-[#E4C788]">
                        <td class="px-6 py-3 border-r border-[#65090D]">{{ $ingredient['name'] }}</td>
                        <td class="px-6 py-3">
                        <div class="flex items-center justify-between w-full">
                            <span>{{ $ingredient['amount'] }}</span>
                                <div class="flex items-center gap-2 ml-auto">
                                <svg onclick="openEditModal('{{ $ingredient['name'] }}', this.closest('tr'))" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#65090D" class="cursor-pointer hover:scale-110 transition">
                                    <path d="M80 0v-160h800V0H80Zm80-240v-170l448-447q11-11 25.5-17t30.5-6q16 0 31 6t27 18l55 56q12 11 17.5 26t5.5 31q0 15-5.5 29.5T777-687L330-240H160Zm504-448 56-56-56-56-56 56 56 56Z"/>
                                </svg>
                                <svg onclick="openDeleteModal('{{ $ingredient['name'] }}', this.closest('tr'))" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#1f1f1f" class="cursor-pointer hover:scale-110 transition">
                                    <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                                </svg>
                                </div>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

                <div class="mt-6 self-end">
                    <a href="{{ url('/menu_index') }}" title="Menu Page">
                        <button type="button" class="bg-[#65090D] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#4e070a] transition">
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
