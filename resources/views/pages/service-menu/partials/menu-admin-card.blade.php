<div class="bg-[#E2BB4D] border-2 border-[#65090D] shadow-md flex w-full relative min-h-[10rem]">
    {{-- image --}}
    <div class="w-32 flex-shrink-0 flex items-center justify-center ml-4 mr-2">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-30 h-30 rounded-full object-cover">
    </div>

    <div class="p-4 flex flex-col justify-between flex-grow">
        <div>
            <h3 class="text-2xl font-bold text-[#65090D]">{{ $name }}</h3>
            <p class="line-clamp-2 text-lg text-[#65090D]">
                {{ $description }}
            </p>
        </div>

        <div class="flex items-center justify-between mt-2">
            <p class="text-xl font-semibold text-[#65090D]">${{ number_format($price) }}</p>
            <div class="flex items-center gap-x-2">
                <a href="{{ url('/edit_menu') }}" title="Edit Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#65090D">
                        <path
                            d="M80 0v-160h800V0H80Zm80-240v-170l448-447q11-11 25.5-17t30.5-6q16 0 31 6t27 18l55 56q12 11 17.5 26t5.5 31q0 15-5.5 29.5T777-687L330-240H160Zm504-448 56-56-56-56-56 56 56 56Z" />
                    </svg>
                </a>
                <button onclick="openDeleteMenuPopup('{{ $id }}')" title="Delete Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#1f1f1f">
                        <path
                            d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div id="deleteMenuPopup" class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full text-center">
        <h2 class="text-xl font-semibold mb-4 text-[#65090D]">Delete Menu</h2>
        <p class="mb-6 text-gray-700">
            Do you really want to delete the "<span id="menuName"></span>" menu item?
        </p>
        <div class="flex justify-center gap-4">
            <button onclick="closeDeletePopup()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
            <button onclick="confirmMenuDelete()"
                class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
        </div>
    </div>
</div>

<script>
    let currentMenuId = '';

    function openDeleteMenuPopup(menuId) {
        currentMenuId = menuId;
        document.getElementById('modalBackdrop').classList.remove('hidden');
        document.getElementById('modalBackdrop').classList.add('flex');
        document.getElementById('menuName').textContent = menuName;
    }

    function closeDeletePopup() {
        document.getElementById('modalBackdrop').classList.remove('flex');
        document.getElementById('modalBackdrop').classList.add('hidden');
    }

    function confirmMenuDelete() {
        alert(`Menu "${currentMenuId}" has been successfully deleted.`);
        closeDeletePopup();
    }
</script>
