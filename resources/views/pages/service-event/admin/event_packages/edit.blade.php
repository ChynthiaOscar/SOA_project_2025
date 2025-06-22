@extends('layouts.app')
@section('title', 'Edit Event Package')
@section('content')
<div class="min-h-screen bg-yellow-50 flex items-center justify-center py-10">
    <div class="bg-slate-200 rounded-lg shadow p-8 w-full max-w-md flex flex-col gap-2">
        <h1 class="text-xl font-bold text-yellow-900 mb-6">Edit Event Package</h1>
        <div>
            <label class="block font-semibold mb-1">Name</label>
            <input type="text" id="name" value="{{ $package->name }}" class="w-full border border-black rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Description</label>
            <textarea id="description" class="w-full border border-black rounded px-3 py-2" rows="3" required>{{ $package->description }}</textarea>
        </div>
        <div>
            <label class="block font-semibold mb-1">Pax</label>
            <input type="number" id="pax" value="{{ $package->pax }}" class="w-full border border-black rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Price</label>
            <input type="number" id="price" value="{{ $package->price }}" class="w-full border border-black rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Event Space</label>
            <select id="event_space_id" class="w-full border border-black rounded px-3 py-2" required>
                <option value="">Select Event Space</option>
                @foreach($eventSpaces as $eventSpace)
                    <option value="{{ $eventSpace->id }}" {{ $eventSpace->id == $package->event_space_id ? 'selected' : '' }}>
                        {{ $eventSpace->id }} - {{ $eventSpace->name }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" id="url" value="{{ route('event-packages.update', $package->id) }}">
        </div>  
        <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('event-packages.index') }}" class="px-4 py-2 rounded bg-gray-500 hover:bg-gray-600 text-white font-semibold">Back</a>
            <button type="submit" id="submit" class="px-4 py-2 rounded bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold">Update</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("submit").addEventListener("click", () => {
            Swal.fire({
                icon: "warning",
                title: "Warning",
                text: "Are you sure to update this Event Package data?",
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = {
                        name: document.getElementById('name').value,
                        description: document.getElementById('description').value,
                        pax: document.getElementById('pax').value,
                        price: document.getElementById('price').value,
                        event_space_id: document.getElementById('event_space_id').value,
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
                                        window.location.href = '{{ route("event-packages.index") }}';
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
