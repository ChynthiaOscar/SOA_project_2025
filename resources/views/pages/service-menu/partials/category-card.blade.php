<div class="relative w-64">
    {{-- Tombol Edit --}}
    <div onclick="openEditPopup('{{ $title }}', {{ $id }})"
        class="absolute left-0 mt-12 ml-2 bg-[#E2BB4D] rounded-full p-2 cursor-pointer hover:bg-[#d3a63f] transition duration-200 z-10">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#65090D">
            <path
                d="M80 0v-160h800V0H80Zm80-240v-170l448-447q11-11 25.5-17t30.5-6q16 0 31 6t27 18l55 56q12 11 17.5 26t5.5 31q0 15-5.5 29.5T777-687L330-240H160Zm504-448 56-56-56-56-56 56 56 56Z" />
        </svg>
    </div>

    {{-- {-- Tombol Delete --} --}}
    <button onclick="openFirstPopup('{{ $title }}', {{ $count }}, {{ $id }})"
        class="absolute -top-2 -right-2 bg-[#65090D] text-white rounded-full p-1 hover:bg-[#7F160C] transition duration-200 shadow-md z-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
    </button>

    <div
        class="group p-2 bg-[#E2BB4D] border-2 border-[#65090D] cursor-pointer shadow-sm transition duration-300 hover:bg-[#E2BB4D]/80">
        <h3 class="text-start text-xl font-bold text-[#65090D] ml-2 mb-4">{{ $title }}</h3>
        <div class="flex items-center justify-between mx-2">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                fill="#65090D">
                <path
                    d="M80 0v-160h800V0H80Zm80-240v-170l448-447q11-11 25.5-17t30.5-6q16 0 31 6t27 18l55 56q12 11 17.5 26t5.5 31q0 15-5.5 29.5T777-687L330-240H160Zm504-448 56-56-56-56-56 56 56 56Z" />
            </svg>
            <p class="text-2xl font-bold text-end mt-1 text-[#65090D]">{{ $count }}</p>
        </div>
    </div>
</div>

<div id="modalBackdrop-{{ $id }}"
    class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 flex">
    <div id="firstPopup-{{ $id }}" class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full text-center">
        <h2 class="text-xl font-semibold mb-4 text-[#65090D]">Delete Category</h2>
        <p class="mb-6 text-gray-700">
            There are <span id="itemCount-{{ $id }}"></span> items under the "<span
                id="categoryName1-{{ $id }}"></span>" category.<br>
            Do you really want to delete it?
        </p>
        <div class="flex justify-center gap-4">
            <button type="button" onclick="closePopup({{ $id }})"
                class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
            <form id="deleteCategoryForm-{{ $id }}" action="{{ route('delete.category', $id) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
            </form>
        </div>
    </div>
</div>

<div id="editModal-{{ $id }}"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg">
        <h2 class="text-xl font-bold text-[#65090D] mb-4">Edit Category</h2>
        <form action="{{ route('update.category', $id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="name" id="editCategoryName-{{ $id }}"
                class="w-full border px-4 py-2 rounded mb-4" placeholder="Enter new category name">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditPopup({{ $id }})"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-[#E2BB4D] text-[#65090D] rounded hover:bg-[#A67D44]">Save</button>
            </div>
        </form>
    </div>
</div>


<script>
    function openFirstPopup(category, count, id) {
        document.getElementById('modalBackdrop-' + id).classList.remove('hidden');
        document.getElementById('itemCount-' + id).textContent = count;
        document.getElementById('categoryName1-' + id).textContent = category;
    }

    function closePopup(id) {
        document.getElementById('modalBackdrop-' + id).classList.add('hidden');
    }

    function openEditPopup(categoryName, id) {
        document.getElementById('editCategoryName-' + id).value = categoryName;
        document.getElementById('editModal-' + id).classList.remove('hidden');
    }

    function closeEditPopup(id) {
        document.getElementById('editModal-' + id).classList.add('hidden');
    }
</script>
