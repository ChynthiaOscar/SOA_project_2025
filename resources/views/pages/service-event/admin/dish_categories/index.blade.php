@extends('layouts.app')
@section('title', 'Dish Categories')
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
                        <h2 class="text-2xl font-semibold text-[#222] mb-2">Search Dish Category</h2>
                        <p class="text-lg text-[#222]">Find dish categories by name or ID</p>
                    </div>
                    <a href="{{ route('dish-categories.create') }}"
                        class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold px-5 py-2 rounded shadow flex items-center gap-2">
                        <i class="fa-solid fa-square-plus"></i>
                        Create
                    </a>
                </div>
                <!-- Search Bar -->
                <form class="relative w-full max-w-md mx-auto mb-6" method="GET" action="{{ route('dish-categories.index') }}">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name ..."
                        class="w-full py-2 px-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-300 ease-in-out">
                    <button type="submit"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-yellow-600 hover:text-yellow-800 transition-all duration-300 ease-in-out">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <!-- Table -->
                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full text-left border border-gray-200">
                        <thead>
                            <tr class="bg-black text-white">
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories ?? [] as $category)
                                <tr
                                    class="{{ $loop->even ? 'bg-[#f7f6fa]' : 'bg-[#f3f1d6]' }} text-[#222] border-b border-gray-200">
                                    <td class="py-3 px-4">{{ $category->name }}</td>
                                    <td class="py-3 px-4 text-center flex gap-2 justify-center">
                                        <a href="{{ route('dish-categories.edit', $category->id) }}"
                                            class="inline-block text-yellow-600 hover:text-yellow-800" title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button"
                                            class="inline-block text-red-600 hover:text-red-800 btn-delete"
                                            data-url="{{ route('dish-categories.destroy', $category->id) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-6 text-center text-gray-400">No data found.</td>
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
