@extends('layouts.app')
@section('title', 'Edit Event Reservation')

@section('content')
    <div class="min-h-screen flex justify-center bg-[#1e1e1e] py-10">
        <div class="bg-[#f7ebc6] border-4 border-[#8b0000] rounded-lg shadow-xl p-8 w-full max-w-5xl">
            <h1 class="text-3xl font-extrabold mb-6 text-center text-[#8b0000]">EDIT EVENT RESERVATION</h1>

            @php
                    $selectedMenus = array_column((array) $reservation->event_menus, 'id');
            @endphp

            <div class="mb-4">
                <label class="block font-bold text-[#8b0000] mb-1">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name"
                    class="w-full border-2 border-[#8b0000] rounded px-3 py-2" value="{{ $reservation->customer_name }}"
                    required>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-[#8b0000] mb-1">Event Space</label>
                <select id="event_space_id" class="w-full border-2 border-[#8b0000] rounded px-3 py-2" required>
                    <option value="" disabled>Select Event Space</option>
                    @foreach ($event_spaces as $e)
                        <option value="{{ $e->id }}" @if ($e->id == $reservation->event_space_id) selected @endif>
                            {{ $e->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-[#8b0000] mb-1">Start Date</label>
                <input type="date" name="start_date" id="start_date"
                    class="w-full border-2 border-[#8b0000] rounded px-3 py-2" value="{{ $reservation->start_date }}"
                    required>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-[#8b0000] mb-1">End Date</label>
                <input type="date" name="end_date" id="end_date"
                    class="w-full border-2 border-[#8b0000] rounded px-3 py-2" value="{{ $reservation->end_date }}"
                    required>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-[#8b0000] mb-1">Number of Pax</label>
                <input type="number" name="pax" id="pax"
                    class="w-full border-2 border-[#8b0000] rounded px-3 py-2" value="{{ $reservation->pax }}" required>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-[#8b0000] mb-1">Notes (optional)</label>
                <textarea name="notes" id="notes" class="w-full border-2 border-[#8b0000] rounded px-3 py-2">{{ $reservation->notes }}</textarea>
            </div>

            @if (!empty($categories))
                @foreach ($categories as $category)
                    @if (isset($category->name) && isset($category->event_menus))
                        <div class="mb-10">
                            <h2 class="text-xl font-extrabold text-[#8b0000] mb-4 uppercase border-b-2 border-[#8b0000]">
                                {{ $category->name }}</h2>
                            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                                @foreach ($category->event_menus as $menu)
                                    <label
                                        class="relative group rounded-lg shadow-lg overflow-hidden border-4 border-yellow-700 bg-[#8b0000] text-white hover:scale-105 transition-all cursor-pointer">
                                        <input type="radio" name="menu_{{ Str::slug($category->name, '_') }}"
                                            value="{{ $menu->id }}"
                                            class="absolute top-2 left-2 w-5 h-5 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded"
                                            {{ in_array($menu->id, $selectedMenus) ? 'checked' : '' }} required>

                                        <div class="w-full h-32 overflow-hidden">
                                            <img src="{{ 'http://localhost:8080/storage/' . $menu->image }}"
                                                alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                        </div>

                                        <div class="p-3 text-center">
                                            <div class="font-bold text-lg">{{ $menu->name }}</div>
                                            <p class="text-sm italic">{{ $menu->description }}</p>
                                            <div class="mt-1 font-semibold text-yellow-300">Rp
                                                {{ number_format($menu->price, 0, ',', '.') }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-center text-gray-500 my-4">No menu categories available</div>
            @endif

            <div class="flex justify-end mt-8">
                <button type="submit" id="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-2 rounded">
                    Update Reservation
                </button>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.getElementById("submit").addEventListener("click", () => {
            Swal.fire({
                icon: "warning",
                title: "Confirm Update",
                text: "Are you sure you want to update this reservation?",
                showDenyButton: true,
                confirmButtonText: 'Update',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    const menus = [];
                    document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                        menus.push(radio.value);
                    });

                    const data = {
                        customer_name: document.getElementById('customer_name').value,
                        start_date: document.getElementById('start_date').value,
                        end_date: document.getElementById('end_date').value,
                        notes: document.getElementById('notes').value,
                        pax: document.getElementById('pax').value,
                        event_space_id: document.getElementById('event_space_id').value,
                        event_menu_id: menus,
                        _method: 'PUT' 
                    };

                    console.log("data", data);

                    fetch(`{{ route('event-reservations.update', $reservation->id) }}`, {
                            method: 'POST', 
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
                                text: error.message || 'An unexpected error occurred.',
                                icon: 'error'
                            });
                        });
                }
            });
        });
    </script>
@endpush
