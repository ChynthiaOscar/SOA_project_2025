@extends('layouts.app')
@section('title', 'Dish Categories')

@section('content')
    <style>
        body {
            background-color: #131313 !important;
        }

        .btn-delete,
        .btn-edit {
            transition: transform 0.2s ease;
        }

        .btn-delete:hover,
        .btn-edit:hover {
            transform: scale(1.1);
        }

        ::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #333;
        }

        ::-webkit-scrollbar-thumb {
            background: #E2BB4D;
            border-radius: 8px;
        }
    </style>

    <div class="min-h-screen bg-[#131313] flex flex-col">
        <!-- Header -->
        <div class="bg-[#7F160C] py-8 px-10 rounded-b-3xl shadow-lg border-b-4 border-[#E2BB4D]">
            <h1 class="text-4xl font-bold text-[#E2BB4D] drop-shadow font-serif text-center">{{ $title }}</h1>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col items-center py-10">
            <div class="w-full max-w-5xl px-4">

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow text-center">{{ session('success') }}</div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-[#E2BB4D] mb-2 font-serif">Search Dish Category</h2>
                        <p class="text-base text-white">Find dish categories by name or ID</p>
                    </div>
                    <a href="{{ route('dish-categories.create') }}"
                        class="bg-[#E2BB4D] hover:bg-[#caa44c] text-[#65090D] font-semibold px-5 py-2 rounded-full shadow flex items-center gap-2 transition-all duration-200 border border-[#a67d44] font-serif">
                        <i class="fa-solid fa-square-plus"></i> Create
                    </a>
                </div>

                <!-- Search Bar -->
                <form class="relative w-full max-w-md mx-auto mb-6" method="GET" action="{{ route('dish-categories.index') }}">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name ..."
                        class="w-full py-2 px-4 text-black border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#E2BB4D] transition-all duration-300 ease-in-out">
                    <button type="submit"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-[#E2BB4D] hover:text-yellow-300 transition-all duration-300 ease-in-out">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

                <!-- Table -->
                <div class="overflow-x-auto rounded-2xl shadow-lg border-4 border-[#E2BB4D] bg-[#65090D]/95">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="bg-[#7F160C] text-[#E2BB4D]">
                                <th class="py-3 px-4 font-bold font-serif">Name</th>
                                <th class="py-3 px-4 font-bold font-serif text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories ?? [] as $category)
                                <tr class="{{ $loop->even ? 'bg-[#A67D44]/30' : 'bg-[#EEEACB]/10' }} text-[#EEEACB] border-b border-[#E2BB4D]/40">
                                    <td class="py-3 px-4">{{ $category->name }}</td>
                                    <td class="py-3 px-4 flex justify-center gap-3">
                                        <a href="{{ route('dish-categories.edit', $category->id) }}"
                                            class="text-[#E2BB4D] hover:text-[#A67D44] transition-all duration-200 btn-edit"
                                            title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button"
                                            class="text-red-500 hover:text-red-300 transition-all duration-200 btn-delete"
                                            data-url="{{ route('dish-categories.destroy', $category->id) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-6 text-center text-[#E2BB4D] font-serif">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($pagination)
                    <div class="my-8 text-white text-center">
                        <nav>
                            <ul class="flex justify-center gap-2">
                                @for ($i = 1; $i <= $pagination->last_page; $i++)
                                    <li>
                                        <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                                            class="px-3 py-1 rounded {{ $i == $pagination->current_page ? 'bg-[#E2BB4D] text-[#65090D] font-bold' : 'hover:text-yellow-400 text-[#EEEACB]' }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
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
                                    await Swal.fire({
                                        title: 'Success',
                                        text: res.message,
                                        icon: "success"
                                    }).then(() => location.reload());
                                } else {
                                    await Swal.fire({
                                        title: 'Error',
                                        text: res.message,
                                        icon: "error"
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Error',
                                    text: error.message || error,
                                    icon: 'error'
                                });
                            });
                    }
                });
            });
        });
    </script>
@endsection
