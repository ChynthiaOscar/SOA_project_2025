@extends('layouts.app')
@section('title', 'Event Menus')
@section('content')
    <div class="min-h-screen bg-[#f3f1d6] flex flex-col">
        <!-- Header -->
        <div class="bg-[#e2c15a] py-8 px-10">
            <h1 class="text-4xl font-bold text-[#222]">EVENT MENUS</h1>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col items-center py-10">
            <div class="w-full max-w-6xl">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">{{ session('success') }}</div>
                @endif

                <!-- Create Button -->
                <div class="flex justify-end mb-6">
                    <a href="{{ route('event-menus.create') }}"
                        class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold px-5 py-2 rounded shadow flex items-center gap-2">
                        <i class="fa-solid fa-square-plus"></i> Create
                    </a>
                </div>

                <!-- Loop by Category -->
                @foreach ($groupedMenus as $category => $menus)
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold text-[#222] mb-4">{{ $category }}</h2>
                        <div class="flex space-x-4 overflow-x-auto pb-2">
                            @foreach ($menus as $menu)
                                <div class="bg-white rounded-lg shadow-md w-60 shrink-0">
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                                        class="w-full h-40 object-cover rounded-t-lg">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-[#222]">{{ $menu->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $menu->description }}</p>
                                        <p class="text-red-600 font-semibold">IDR {{ $menu->price }}K</p>
                                        <div class="mt-4 flex justify-between text-sm text-[#333]">
                                            <a href="{{ route('event-menus.edit', $menu->id) }}"
                                                class="text-yellow-600 hover:text-yellow-800">
                                                <i class="fa-solid fa-pencil"></i> Edit
                                            </a>
                                            <button class="text-red-600 hover:text-red-800 btn-delete"
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
                                    await Swal.fire({
                                        title: 'Deleted!',
                                        text: res.message,
                                        icon: "success"
                                    });
                                    location.reload();
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
