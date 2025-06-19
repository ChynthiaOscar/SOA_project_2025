@extends('layouts.app')
@section('title', 'Edit Event Menu')
@section('content')
    <div class="min-h-screen bg-yellow-50 flex items-center justify-center py-10">
        <div class="bg-slate-200 rounded-lg shadow p-8 w-full max-w-md flex flex-col gap-2">
            <h1 class="text-xl font-bold text-yellow-900 mb-6">{{ $title }}</h1>

            <div>
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" id="name" class="w-full border border-black rounded px-3 py-2"
                    value="{{ $event_menu->name }}">
            </div>

            <div>
                <label class="block font-semibold mb-1">Price</label>
                <input type="number" id="price" class="w-full border border-black rounded px-3 py-2"
                    value="{{ $event_menu->price }}">
            </div>

            <div>
                <label class="block font-semibold mb-1">Dish Category</label>
                <select id="dish_category_id" class="w-full border border-black rounded px-3 py-2" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ $event_menu->dish_category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1">Description</label>
                <textarea id="description" class="w-full border border-black rounded px-3 py-2" required>{{ $event_menu->description }}</textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">Image</label>
                <input type="file" id="image" class="w-full border border-black rounded px-3 py-2" accept="image/*">
                <input type="hidden" id="url" value="{{ route('event-menus.update', $event_menu->id) }}">
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('event-menus.index') }}"
                    class="px-4 py-2 rounded bg-gray-500 hover:bg-gray-600 text-white font-semibold">Back</a>
                <button type="submit" id="submit"
                    class="px-4 py-2 rounded bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold">Submit</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById("submit").addEventListener("click", () => {
            Swal.fire({
                icon: "warning",
                title: "Warning",
                text: "Are you sure to update this Event Menu?",
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append("name", document.getElementById("name").value);
                    formData.append("price", document.getElementById("price").value);
                    formData.append("description", document.getElementById("description").value);
                    formData.append("dish_category_id", document.getElementById("dish_category_id").value);
                    const image = document.getElementById("image").files[0];
                    if (image) formData.append("image", image);
                    console.log(document.getElementById("url").value);
                    formData.append("_method", "PUT");

                    fetch(document.getElementById("url").value, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(async res => {
                            if (res.success) {
                                await Swal.fire({
                                    title: 'Success',
                                    text: res.message,
                                    icon: "success"
                                });
                                location.href = "{{ route('event-menus.index') }}";
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
    </script>
@endpush
