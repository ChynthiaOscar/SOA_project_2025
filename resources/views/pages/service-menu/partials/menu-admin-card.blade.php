<div class="bg-[#E2BB4D] border-2 border-[#65090D] shadow-md flex w-full relative min-h-[10rem]">
    {{-- Image --}}
    <div class="w-32 flex-shrink-0 flex items-center justify-center ml-4 mr-2">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-30 h-30 rounded-full object-cover">
    </div>

    <div class="p-4 flex flex-col justify-between flex-grow">
        <div>
            <h3 class="text-2xl font-bold text-[#65090D]">{{ $name }}</h3>
            <p class="text-lg text-[#65090D] line-clamp-2">{{ $description }}</p>
        </div>

        <div class="flex items-center justify-between mt-2">
            <p class="text-xl font-semibold text-[#65090D]">${{ number_format($price) }}</p>
            <div class="flex items-center gap-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#65090D">
                <path d="M80 0v-160h800V0H80Zm80-240v-170l448-447q11-11 25.5-17t30.5-6q16 0 31 6t27 18l55 56q12 11 17.5 26t5.5 31q0 15-5.5 29.5T777-687L330-240H160Zm504-448 56-56-56-56-56 56 56 56Z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
            </svg>
            </div>
        </div>
    </div>
</div>
