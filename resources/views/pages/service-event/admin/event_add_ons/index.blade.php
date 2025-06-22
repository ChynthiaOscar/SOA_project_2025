@extends('layouts.app')
@section('title', 'Event Add-Ons')

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
                    <i class="fa-solid fa-puzzle-piece text-3xl text-[#E2BB4D] drop-shadow"></i>
                    <span
                        class="text-3xl md:text-4xl font-extrabold tracking-wider text-[#E2BB4D] drop-shadow-lg font-serif">
                        Event Add-Ons
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
                    <form class="relative w-full max-w-md mx-auto" method="GET" action="{{ route('event-addon.index') }}">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name..."
                            class="w-full py-2 px-4 border-2 border-[#E2BB4D] bg-[#EEEACB] text-[#65090D] rounded-full focus:outline-none focus:ring-2 focus:ring-[#E2BB4D] transition-all duration-300 ease-in-out font-semibold">
                        <button type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-[#E2BB4D] hover:text-[#A67D44] transition-all duration-300 ease-in-out">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-[#E2BB4D] mb-2 font-serif tracking-wider">Event Add-Ons</h2>
                    <a href="{{ route('event-addon.create') }}"
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
                                <th class="py-3 px-4 font-bold font-serif">Price</th>
                                <th class="py-3 px-4 font-bold font-serif">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($add_ons ?? [] as $add_on)
                                <tr
                                    class="{{ $loop->even ? 'bg-[#A67D44]/30' : 'bg-[#EEEACB]/10' }} text-[#EEEACB] border-b border-[#E2BB4D]/40">
                                    <td class="py-3 px-4">{{ $add_on->name }}</td>
                                    <td class="py-3 px-4">Rp {{ number_format($add_on->price, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center flex gap-2 justify-center">
                                        <a href="{{ route('event-addon.edit', $add_on->id) }}"
                                            class="text-[#E2BB4D] hover:text-[#A67D44] transition-all duration-200"
                                            title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button"
                                            class="text-red-600 hover:text-red-800 transition-all duration-200 btn-delete"
                                            data-url="{{ route('event-addon.destroy', $add_on->id) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-[#E2BB4D] font-serif">No data found.</td>
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
