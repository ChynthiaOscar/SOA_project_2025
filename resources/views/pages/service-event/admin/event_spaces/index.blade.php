@extends('layouts.app')
@section('title', 'Event Spaces')
@section('content')
    <div class="min-h-screen bg-[#f3f1d6] flex flex-col">
        <!-- Header -->
        <div class="bg-[#e2c15a] py-8 px-10">
            <h1 class="text-4xl font-bold text-[#222]">{{ $title }}</h1>
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col items-center py-10">
            <div class="w-full max-w-5xl">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">{{ session('success') }}</div>
                @endif
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-[#222] mb-2">Search Event Space</h2>
                        <p class="text-lg text-[#222]">Find event packages by name or ID</p>
                    </div>
                    <a href="{{ route('event-space.create') }}"
                        class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold px-5 py-2 rounded shadow flex items-center gap-2">
                        <i class="fa-solid fa-square-plus"></i>
                        Create
                    </a>
                </div>
                <!-- Search Bar -->
                <form class="flex items-center mb-6 w-full" method="GET" action="{{ url('event-packages') }}">
                    <div class="flex items-center bg-white rounded-full shadow px-4 py-2 w-full max-w-3xl">
                        <svg class="w-6 h-6 text-[#222] mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search"
                            class="w-full border-none outline-none bg-transparent text-lg py-2" />
                    </div>
                </form>
                <!-- Table -->
                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full text-left border border-gray-200">
                        <thead>
                            <tr class="bg-black text-white">
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4">Location</th>
                                <th class="py-3 px-4">Capacity</th>
                                <th class="py-3 px-4">Price</th>
                                <th class="py-3 px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($spaces ?? [] as $space)
                                <tr
                                    class="{{ $loop->even ? 'bg-[#f7f6fa]' : 'bg-[#f3f1d6]' }} text-[#222] border-b border-gray-200">
                                    <td class="py-3 px-4">{{ $space->name }}</td>
                                    <td class="py-3 px-4">{{ $space->location }}</td>
                                    <td class="py-3 px-4">{{ $space->capacity }}</td>
                                    <td class="py-3 px-4">Rp {{ number_format($space->price, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center flex gap-2 justify-center">
                                        <a href="{{ route('event-space.edit', $space->id) }}"
                                            class="inline-block text-yellow-600 hover:text-yellow-800" title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button"
                                            class="inline-block text-red-600 hover:text-red-800 btn-delete"
                                            data-url="{{ route('event-space.destroy', $space->id) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-400">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($pagination)
                        <div class="my-8">
                            <nav>
                                <ul class="flex gap-2">
                                    @for ($i = 1; $i <= $pagination->last_page; $i++)
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                                                class="{{ $i == $pagination->current_page ? 'font-bold' : '' }}">
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
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                            return;
                                        }
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
@endsection
