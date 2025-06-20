<div class="p-2 bg-[#65090D] border-4 border-[#65090D] w-72">
    <div class="px-8 py-3 border-4 border-[#A67D44]">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-56 h-48 mx-auto rounded-full object-cover -mt-28 ">
            <div>
                <div class="flex justify-center gap-1 text-[#E09121] mt-2">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="w-7 h-7 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.561-.955L10 0l2.949 5.955 6.561.955-4.755 4.635 1.123 6.545z"/>
                        </svg>
                    @endfor
                </div>
                <h3 class="font-serif text-center text-xl text-[#EEEACB] mt-2">{{ $title }}</h3>
                <p class="text-sm text-center mt-1 mb-1 text-[#E2BB4D]">{{ $description }}</p>
                <p class="text-base text-center mt-2 font-bold text-[#EEEACB]">IDR {{ $price }}</p>
            </div>
        </div>
</div>
