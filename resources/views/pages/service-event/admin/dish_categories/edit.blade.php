@extends('layouts.app')
@section('title', 'Edit Dish Category')
@section('content')
    <div class="min-h-screen bg-yellow-50 flex items-center justify-center py-10">
        <div class="bg-slate-200 rounded-lg shadow p-8 w-full max-w-md flex flex-col gap-2">
            <h1 class="text-xl font-bold text-yellow-900 mb-6">{{ $title }}</h1>
            <div>
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" id="name" class="w-full border border-black rounded px-3 py-2" value="{{ $dish_category->name }}">
                <input type="hidden" id="url" value="{{ route('dish-categories.update', $dish_category->id) }}">
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('dish-categories.index') }}"
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
                text: "Are you sure to update this Dish Category?",
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = {
                        name: document.getElementById('name').value,
                    };
                    fetch(document.getElementById('url').value, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(data)
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
                                        location.href="{{ route('dish-categories.index') }}";
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
    </script>
@endpush
