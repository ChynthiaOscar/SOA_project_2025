<div class="relative p-3 bg-[#65090D] border-4 border-[#65090D] w-80">
    <!-- Sold Out badge -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center z-10 rounded-md">
            <div class="absolute top-0 right-0 bg-[#65090D] border border-[#A67D44] text-[#EEEACB] text-xs font-bold px-3 py-1 rounded-bl-lg z-20">
                Sold Out
            </div>
    </div>

    <div class="px-3 py-2 border-4 border-[#A67D44] relative">
        <div class="relative flex justify-center">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-40 h-40 rounded-full object-cover -mt-16 z-10">
            <div class="absolute top-0 w-40 h-40 rounded-full bg-black bg-opacity-50 -mt-16 z-20 m-2"></div>
        </div>
            <div class="flex justify-center gap-1 text-[#E09121] mt-2">
                @for ($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.561-.955L10 0l2.949 5.955 6.561.955-4.755 4.635 1.123 6.545z"/>
                    </svg>
                @endfor
            </div>
            <h3 class="font-serif text-center text-2xl text-[#EEEACB] mt-3">{{ $title }}</h3>
            <p class="text-sm text-center mt-2 mb-2 text-[#E2BB4D]">{{ $description }}</p>
            <div class="grid grid-cols-2 justify-items-between mt-4">
                <p class="text-lg text-start mt-3 font-bold text-[#EEEACB] ml-3">IDR {{ $price }}</p>
                <a class="bg-[#A67D44] px-2 py-2 rounded-full transition duration-300 justify-self-end w-fit cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#65090D">
                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/>
                    </svg>
                </a>
            </div>  
        </div>
    </div>
</div>
