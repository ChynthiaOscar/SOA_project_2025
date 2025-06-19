@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#131313] pt-16 md:pl-[25%] xl:pl-[15%] relative overflow-x-hidden">
        <aside
            class="hidden md:flex fixed top-0 left-0 h-screen w-[25%] xl:w-[15%] bg-[#E2BB4D] items-center justify-end py-10 z-20"
            style="clip-path: ellipse(92% 70% at 0% 50%); overflow: visible;">
            <aside
                class="fixed top-0 left-0 h-screen w-[25%] xl:w-[15%] bg-[#65090D] text-[#E2BB4D] flex items-center justify-end pr-6 py-10"
                style="clip-path: ellipse(90% 70% at 0% 50%); overflow: visible;">
                <div class="relative w-[300px] h-[300px] mx-auto mt-10">
                    <ul id="circle" class="absolute inset-0 flex items-center justify-center">
                        @foreach ($categories as $category)
                            <li onclick="rotateTo(this)"
                                class="menu-item absolute font-serif hover:text-[#E09121] cursor-pointer text-right"
                                style="text-shadow: 1px 1px 5px #000;">{{ $category['name'] }}</li>
                        @endforeach
                    </ul>
                    <div
                        class="absolute right-[-2px] top-1/2 -translate-y-1/2 translate-x-1/2 bg-[#E2BB4D] w-4 h-4 rounded-full shadow-lg">
                    </div>
                </div>
            </aside>
        </aside>

        <div class="md:hidden bg-[#65090D] text-[#E2BB4D] overflow-x-auto whitespace-nowrap flex gap-6 px-4 py-3">
            @foreach ($categories as $category)
                <span
                    class="font-serif hover:text-[#E09121] cursor-pointer text-sm whitespace-nowrap">{{ $category['name'] }}</span>
            @endforeach
        </div>

        <!-- Search bar -->
        <div class="w-full pt-6 sm:pt-10 md:pt-6 px-4">
            <div
                class="border border-[#E2BB4D] px-3 sm:px-4 py-2 flex items-center gap-2 sm:gap-3 w-full max-w-xs sm:max-w-md md:max-w-xl mx-auto bg-[#131313]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="#E2BB4D" class="w-4 h-4 sm:w-5 sm:h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1011.25 18.75a7.5 7.5 0 005.4-2.1z" />
                </svg>
                <input type="text" placeholder="Search Menu"
                    class="font-serif flex-1 bg-[#131313] text-[#E2BB4D] focus:outline-none px-1 sm:px-2 py-1 placeholder-[#E2BB4D] text-sm sm:text-base">
            </div>
        </div>


        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 md:mt-24">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-x-6 gap-y-16 justify-items-center mb-8">
                @foreach ($menus as $key => $menu)
                    @include('pages.service-menu.partials.menu-order-card', [
                        'image' => asset('images/service-menu/mongolian-beef.png'),
                        'title' => $menu['name'],
                        'description' => $menu['description'],
                        'price' => $menu['price'],
                    ])
                @endforeach
                @include('pages.service-menu.partials.sold-out-menu-card', [
                    'image' => asset('images/service-menu/mongolian-beef.png'),
                    'title' => 'Mongolian Beef',
                    'description' => 'a sweet and savory stir-fry with e',
                    'price' => '175',
                ])
            </div>
        </div>


        <!-- My Order Button -->
        <div class="fixed bottom-10 right-10 z-30">
            <a href="#"
                class="bg-[#65090D] px-3 py-3 rounded-full shadow-lg hover:bg-[#7F160C] transition duration-300 border-2 border-[#E2BB4D] flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="40px"
                    fill="#E2BB4D">
                    <path
                        d="M80-200v-66.67h800V-200H80Zm33.33-120v-24.67q0-146 85.17-242T413.33-710v-23.33q0-28.34 19.17-47.5Q451.67-800 480-800t47.5 19.17q19.17 19.16 19.17 47.5V-710q130 27.33 215 123.33t85 242V-320H113.33Z" />
                </svg>
            </a>
        </div>
    </div>

    <style>
        .menu-item {
            position: absolute;
            white-space: nowrap;
            transform: translate(-100%, -50%);
            transition: left 0.5s ease-out, top 0.5s ease-out, color 0.3s ease;
        }
    </style>

    <script>
        const circleElement = document.getElementById('circle');
        const items = document.querySelectorAll('.menu-item');
        const totalItems = items.length;

        const radius = 250;
        const centerX = -80;
        const centerY = 150;
        const startAngleDeg = -90;
        const endAngleDeg = 90;
        const totalAngleSpan = endAngleDeg - startAngleDeg;
        const anglePerItem = totalItems > 1 ? totalAngleSpan / (totalItems - 1) : 0;

        const targetClickAngleDeg = 0;
        let currentOffsetAngleDeg = 0;
        const maxOffsetAngle = 0 - startAngleDeg;
        const minOffsetAngle = 0 - (startAngleDeg + ((totalItems - 1) * anglePerItem));

        function updatePositions() {
            items.forEach((item, i) => {
                let baseAngleDeg = startAngleDeg + (i * anglePerItem);
                let finalAngleDeg = baseAngleDeg + currentOffsetAngleDeg;
                const angleRad = (finalAngleDeg * Math.PI) / 180;
                const x = centerX + radius * Math.cos(angleRad);
                const y = centerY + radius * Math.sin(angleRad);
                item.style.position = 'absolute';
                item.style.left = `${x}px`;
                item.style.top = `${y}px`;
            });
        }

        function rotateTo(clickedItem) {
            const targetIndex = Array.from(items).indexOf(clickedItem);
            const currentClickedItemAngle = startAngleDeg + (targetIndex * anglePerItem);
            let newOffset = targetClickAngleDeg - currentClickedItemAngle;

            currentOffsetAngleDeg = Math.max(minOffsetAngle, Math.min(maxOffsetAngle, newOffset));
            updatePositions();
        }

        let scrollAccumulator = 0;
        const scrollThreshold = 100;

        circleElement?.addEventListener('wheel', (event) => {
            event.preventDefault();
            scrollAccumulator += event.deltaY;
            if (scrollAccumulator > scrollThreshold) {
                currentOffsetAngleDeg = Math.max(minOffsetAngle, currentOffsetAngleDeg - anglePerItem);
                updatePositions();
                scrollAccumulator = 0;
            } else if (scrollAccumulator < -scrollThreshold) {
                currentOffsetAngleDeg = Math.min(maxOffsetAngle, currentOffsetAngleDeg + anglePerItem);
                updatePositions();
                scrollAccumulator = 0;
            }
        });

        items.forEach(item => {
            item.addEventListener('click', () => {
                rotateTo(item);
            });
        });

        updatePositions();
    </script>
@endsection
