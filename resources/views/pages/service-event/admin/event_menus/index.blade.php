@extends('layouts.app')
@section('title', 'Event Menus')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #131313, #1f1f1f);
            color: #fff;
        }

        .menu-card {
            background-color: #EEEACB;
            border: 4px solid #E2BB4D;
            border-radius: 1.5rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeUp 0.5s ease both;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(226, 187, 77, 0.3);
        }

        .menu-image {
            height: 160px;
            object-fit: cover;
        }

        .menu-category {
            font-size: 1.75rem;
            font-weight: 700;
            color: #E2BB4D;
            font-family: 'Georgia', serif;
        }

        .menu-price {
            color: #7F160C;
            font-weight: bold;
        }

        .action-button {
            transition: all 0.3s ease;
        }

        .action-button:hover {
            text-decoration: underline;
            transform: scale(1.05);
        }

        ::-webkit-scrollbar {
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #333;
        }

        ::-webkit-scrollbar-thumb {
            background: #E2BB4D;
            border-radius: 10px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Vanilla Tilt -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>

    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <div class="bg-[#7F160C] py-8 px-10 rounded-b-3xl shadow-lg border-b-4 border-[#E2BB4D]">
            <div class="flex items-center justify-center py-4">
                <div class="bg-[#65090D] px-8 py-4 rounded-2xl shadow-xl border-4 border-[#E2BB4D] flex items-center gap-3">
                    <i class="fa-solid fa-utensils text-3xl text-[#E2BB4D] drop-shadow"></i>
                    <span class="text-3xl md:text-4xl font-extrabold tracking-wider text-[#E2BB4D] drop-shadow-lg font-serif">
                        Event Menus
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col items-center py-10">
            <div class="w-full max-w-6xl px-4">

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">{{ session('success') }}</div>
                @endif

                <!-- Search Bar -->
                <div class="mb-6">
                    <input type="text" id="menuSearch"
                        class="w-full px-4 py-2 rounded-full text-black focus:outline-none shadow border border-gray-300"
                        placeholder="Search menu...">
                </div>

                <!-- Create Button -->
                <div class="flex justify-end mb-6">
                    <a href="{{ route('event-menus.create') }}"
                        class="bg-[#E2BB4D] hover:bg-[#A67D44] text-[#65090D] font-bold px-5 py-2 rounded-full shadow flex items-center gap-2 transition-all duration-200 border-2 border-[#A67D44] font-serif">
                        <i class="fa-solid fa-square-plus"></i> Create
                    </a>
                </div>

                <!-- Loop by Category -->
                @foreach ($categories as $category)
                    <div class="mb-10">
                        <h2 class="menu-category mb-4">{{ $category->name }}</h2>
                        <div class="flex space-x-4 overflow-x-auto pb-2">
                            @foreach ($category->event_menus as $menu)
                                <div class="menu-card w-60 shrink-0" data-tilt>
                                    <img src="{{ env('STORAGE_URL') . $menu->image }}" alt="{{ $menu->name }}"
                                        class="menu-image w-full">
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold text-[#222] font-serif">{{ $menu->name }}</h3>
                                        <p class="text-sm text-gray-600 italic mb-2">{{ $menu->description }}</p>
                                        <p class="menu-price text-sm mb-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                        <div class="flex justify-between items-center text-sm">
                                            <a href="{{ route('event-menus.edit', $menu->id) }}"
                                                class="text-yellow-700 hover:text-yellow-900 font-semibold action-button">
                                                <i class="fa-solid fa-pencil"></i> Edit
                                            </a>
                                            <button class="text-red-700 hover:text-red-900 font-semibold action-button btn-delete"
                                                data-url="{{ route('event-menus.destroy', $menu->id) }}">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Delete -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This menu will be deleted permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(this.dataset.url, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                            })
                            .then(response => response.json())
                            .then(async res => {
                                if (res.success) {
                                    await Swal.fire('Deleted!', res.message, 'success');
                                    location.reload();
                                } else {
                                    await Swal.fire('Error!', res.message, 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error!', error.message || error, 'error');
                            });
                    }
                });
            });
        });

        // Vanilla Tilt Init
        VanillaTilt.init(document.querySelectorAll(".menu-card"), {
            max: 10,
            speed: 400,
            glare: true,
            "max-glare": 0.2,
        });

        // Search Filtering
        document.getElementById('menuSearch').addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('.menu-card').forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                card.style.display = name.includes(keyword) ? 'block' : 'none';
            });
        });
    </script>
@endsection
