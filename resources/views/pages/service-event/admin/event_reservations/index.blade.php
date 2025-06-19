@extends('layouts.app')
@section('title', 'Event Reservations')
@section('content')
<div class="min-h-screen bg-[#f3f1d6] flex flex-col">
    <div class="bg-[#e2c15a] py-8 px-10">
        <h1 class="text-4xl font-bold text-[#222]">{{ $title }}</h1>
    </div>
    <div class="flex-1 flex flex-col items-center py-10">
        <div class="w-full max-w-5xl">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">{{ session('success') }}</div>
            @endif
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-semibold text-[#222] mb-2">Event Reservations</h2>
                </div>
                <a href="{{ route('event-reservations.create') }}"
                    class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold px-5 py-2 rounded shadow flex items-center gap-2">
                    <i class="fa-solid fa-square-plus"></i>
                    Create
                </a>
            </div>
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full text-left border border-gray-200">
                    <thead>
                        <tr class="bg-black text-white">
                            <th class="py-3 px-4">Customer</th>
                            <th class="py-3 px-4">Event Date</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations ?? [] as $reservation)
                            <tr class="{{ $loop->even ? 'bg-[#f7f6fa]' : 'bg-[#f3f1d6]' }} text-[#222] border-b border-gray-200">
                                <td class="py-3 px-4">{{ $reservation->customer_name }}</td>
                                <td class="py-3 px-4">
                                    {{ \Carbon\Carbon::parse($reservation->event_date)->format('d M Y') }}
                                </td>
                                <td class="py-3 px-4">{{ ucfirst($reservation->status) }}</td>
                                <td class="py-3 px-4 text-center flex gap-2 justify-center">
                                    <a href="{{ route('event-reservations.edit', $reservation->id) }}"
                                        class="inline-block text-yellow-600 hover:text-yellow-800" title="Edit">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('event-reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Delete this reservation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block text-red-600 hover:text-red-800">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
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
@endsection

@push('scripts')
<script>
document.querySelectorAll('form[onsubmit]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
