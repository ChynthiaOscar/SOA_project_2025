@extends('layouts.app')
@section('title', 'Edit Event Reservation')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-10">
    <div class="bg-white rounded-lg shadow p-8 w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Edit Event Reservation</h1>
        <form id="reservationForm" method="POST" action="{{ route('event-reservations.update', $reservation->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold mb-1">Customer Name</label>
                <input type="text" name="user" class="w-full border rounded px-3 py-2" value="{{ $reservation->customer_name }}" required>
            </div>
            <!-- Event Date -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Event Date</label>
                <input type="date" name="date" class="w-full border rounded px-3 py-2" value="{{ isset($reservation->event_date) ? \Carbon\Carbon::parse($reservation->event_date)->format('Y-m-d') : '' }}" required>
            </div>
            <!-- Notes -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Notes</label>
                <textarea name="detail" class="w-full border rounded px-3 py-2">{{ $reservation->notes ?? '' }}</textarea>
            </div>
            <!-- Total Price -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Total Price</label>
                <input type="number" name="total_price" class="w-full border rounded px-3 py-2" min="0" step="0.01" value="{{ $reservation->total_price ?? '' }}" placeholder="Enter total price">
            </div>
            <!-- Menu Selection -->
            @if(!empty($categories))
                @foreach($categories as $category)
                    @if(isset($category->name) && isset($category->menus) && !empty($category->menus))
                        <div class="mb-6">
                            <label class="block font-semibold mb-2 text-lg">{{ $category->name }}</label>
                            <div class="flex overflow-x-auto gap-4 pb-2">
                                @foreach($category->menus as $menu)
                                    @if(isset($menu->name))
                                        <label class="flex flex-col items-center min-w-[120px] p-2 border rounded hover:bg-gray-50 cursor-pointer">
                                            <div class="w-16 h-16 bg-yellow-100 rounded-full mb-2 flex items-center justify-center">
                                                <span class="text-2xl">🍽️</span>
                                            </div>
                                            <input type="radio" name="{{ Str::slug($category->name) }}" value="{{ $menu->name }}" class="mb-1"
                                                {{ (isset($reservation->{Str::slug($category->name)}) && $reservation->{Str::slug($category->name)} == $menu->name) ? 'checked' : '' }}>
                                            <span class="text-sm text-center font-medium">{{ $menu->name }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-center text-gray-500 my-4">
                    No menu categories available
                </div>
            @endif
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('reservationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Update Reservation?',
        text: 'Are you sure you want to update this reservation?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, update',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit();
        }
    });
});
</script>
@endpush
