<div class="relative w-64">
    <button onclick="openFirstPopup('{{ $title }}', {{ $count }})"
        class="absolute -top-2 -right-2 bg-[#65090D] text-white rounded-full p-1 hover:bg-[#7F160C] transition duration-200 shadow-md z-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
    </button>

    <div class="group p-2 bg-[#E2BB4D] border-2 border-[#65090D] cursor-pointer shadow-sm transition duration-300 hover:bg-[#E2BB4D]/80">
        <h3 class="text-start text-xl font-bold text-[#65090D] ml-2 mb-4">{{ $title }}</h3>
        <div class="flex items-center justify-between mx-2">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#65090D">
                <path d="M80 0v-160h800V0H80Zm80-240v-170l448-447q11-11 25.5-17t30.5-6q16 0 31 6t27 18l55 56q12 11 17.5 26t5.5 31q0 15-5.5 29.5T777-687L330-240H160Zm504-448 56-56-56-56-56 56 56 56Z"/>
            </svg>
            <p class="text-2xl font-bold text-end mt-1 text-[#65090D]">{{ $count }}</p>
        </div>
    </div>
</div>

<div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 flex">
    <div id="firstPopup" class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full text-center">
        <h2 class="text-xl font-semibold mb-4 text-[#65090D]">Delete Category</h2>
        <p class="mb-6 text-gray-700">
            There are <span id="itemCount"></span> items under the "<span id="categoryName1"></span>" category.<br>
            Do you really want to delete it?
        </p>
        <div class="flex justify-center gap-4">
            <button onclick="closePopup()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
            <button onclick="confirmDelete()" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
        </div>
    </div>
</div>

<script>
    let currentCategory = '';
    let currentCount = 0;

    function openFirstPopup(category, count) {
        currentCategory = category;
        currentCount = count;
        document.getElementById('modalBackdrop').classList.remove('hidden');
        document.getElementById('itemCount').textContent = count;
        document.getElementById('categoryName1').textContent = category;
    }

    function closePopup() {
        document.getElementById('modalBackdrop').classList.add('hidden');
    }

    function confirmDelete() {
        alert(`Category "${currentCategory}" has been successfully deleted.`);
        closePopup();
        // nti buat delete logic
    }
</script>
