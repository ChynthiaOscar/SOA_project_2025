@extends('layouts.app')
@section('title', 'Event Spaces')

@section('content')
    <style>
        body {
            background-color: #131313 !important;
        }
    </style>

    <div class="min-h-screen bg-[#131313] flex flex-col">
        <!-- Header -->
        <div class="bg-[#7F160C] py-8 px-10 rounded-b-3xl shadow-lg border-b-4 border-[#E2BB4D]">
            <div class="flex items-center justify-center py-4">
                <div
                    class="bg-[#65090D] px-8 py-4 rounded-2xl shadow-xl border-4 border-[#E2BB4D] flex items-center gap-3">
                    <i class="fa-solid fa-building-user text-3xl text-[#E2BB4D] drop-shadow"></i>
                    <span
                        class="text-3xl md:text-4xl font-extrabold tracking-wider text-[#E2BB4D] drop-shadow-lg font-serif">
                        Event Spaces
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col items-center py-10">
            <div class="w-full max-w-5xl">

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search Bar -->
                <div class="mb-4">
                    <form class="relative w-full max-w-md mx-auto" method="GET" action="{{ route('event-space.index') }}">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name or location..."
                            class="w-full py-2 px-4 border-2 border-[#E2BB4D] bg-[#EEEACB] text-[#65090D] rounded-full focus:outline-none focus:ring-2 focus:ring-[#E2BB4D] transition-all duration-300 ease-in-out font-semibold">
                        <button type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-[#E2BB4D] hover:text-[#A67D44] transition-all duration-300 ease-in-out">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-[#E2BB4D] mb-2 font-serif tracking-wider">Event Spaces</h2>
                    <a href="{{ route('event-space.create') }}"
                        class="bg-[#E2BB4D] hover:bg-[#A67D44] text-[#65090D] font-bold px-5 py-2 rounded-full shadow flex items-center gap-2 transition-all duration-200 border-2 border-[#A67D44] font-serif">
                        <i class="fa-solid fa-square-plus"></i> Create
                    </a>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-2xl shadow-lg border-4 border-[#E2BB4D] bg-[#65090D]/95">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="bg-[#7F160C] text-[#E2BB4D]">
                                <th class="py-3 px-4 font-bold font-serif">Name</th>
                                <th class="py-3 px-4 font-bold font-serif">Location</th>
                                <th class="py-3 px-4 font-bold font-serif">Capacity</th>
                                <th class="py-3 px-4 font-bold font-serif">Price</th>
                                <th class="py-3 px-4 font-bold font-serif">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($spaces ?? [] as $space)
                                <tr
                                    class="{{ $loop->even ? 'bg-[#A67D44]/30' : 'bg-[#EEEACB]/10' }} text-[#EEEACB] border-b border-[#E2BB4D]/40">
                                    <td class="py-3 px-4">{{ $space->name }}</td>
                                    <td class="py-3 px-4">{{ $space->location }}</td>
                                    <td class="py-3 px-4">{{ $space->capacity }}</td>
                                    <td class="py-3 px-4">Rp {{ number_format($space->price, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center flex gap-2 justify-center">
                                        <a href="{{ route('event-space.edit', $space->id) }}"
                                            class="text-[#E2BB4D] hover:text-[#A67D44] transition-all duration-200"
                                            title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button"
                                            class="text-red-600 hover:text-red-800 transition-all duration-200 btn-delete"
                                            data-url="{{ route('event-space.destroy', $space->id) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-[#E2BB4D] font-serif">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if ($pagination)
                        <div class="my-8">
                            <nav>
                                <ul class="flex gap-2 justify-center">
                                    @for ($i = 1; $i <= $pagination->last_page; $i++)
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                                                class="{{ $i == $pagination->current_page ? 'font-bold text-[#E2BB4D]' : 'text-[#EEEACB]' }} font-serif">
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
    </div>
@endsection

@push('scripts')
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
                                    }).then(() => {
                                        location.reload();
                                    });
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
@endpush
