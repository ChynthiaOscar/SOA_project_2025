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
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Customer</th>
                            <th class="py-3 px-4">Start Date</th>
                            <th class="py-3 px-4">End Date</th>
                            <th class="py-3 px-4">Pax</th>
                            <th class="py-3 px-4">Total Price</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations ?? [] as $reservation)
                            <tr class="{{ $loop->even ? 'bg-[#f7f6fa]' : 'bg-[#f3f1d6]' }} text-[#222] border-b border-gray-200">
                                <td class="py-3 px-4">{{ $reservation->id }}</td>
                                <td class="py-3 px-4">{{ $reservation->customer_name }}</td>
                                <td class="py-3 px-4">
                                    @if(isset($reservation->start_date))
                                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('d M Y') }}
                                    @else
                                        <span class="text-red-500">No date</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if(isset($reservation->end_date))
                                        {{ \Carbon\Carbon::parse($reservation->end_date)->format('d M Y') }}
                                    @else
                                        <span class="text-red-500">No date</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">{{ $reservation->pax }}</td>
                                <td class="py-3 px-4">{{ number_format($reservation->total_price, 2) }}</td>
                                <td class="py-3 px-4">{{ ucfirst($reservation->status) }}</td>
                                <td class="py-3 px-4 text-center flex gap-2 justify-center">
                                    <a href="{{ route('event-reservations.edit', $reservation->id) }}"
                                        class="inline-block text-yellow-600 hover:text-yellow-800" title="Edit">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('event-reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Delete this reservation?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block text-red-600 hover:text-red-800">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    <button type="button" onclick='showMenus(@json($reservation->event_menus ?? []))'
                                        class="inline-block text-blue-600 hover:text-blue-800" title="View Menus">
                                        <i class="fa-solid fa-list"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-6 text-center text-gray-400">No data found.</td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showMenus(menus) {
    let htmlContent = '';
    if (menus.length > 0) {
        htmlContent = '<div class="text-left">';
        menus.forEach(menu => {
            htmlContent += `
                <div class="mb-3 p-2 border-b border-gray-200">
                    <p class="text-lg font-semibold">🍽️ ${menu.name}</p>
                </div>`;
        });
        htmlContent += '</div>';
    } else {
        htmlContent = '<p class="text-gray-500">No menu items available.</p>';
    }

    Swal.fire({
        title: 'Menu List',
        html: htmlContent,
        icon: 'info',
        showCloseButton: true,
        confirmButtonColor: '#e2c15a',
        confirmButtonText: 'Close',
        customClass: {
            popup: 'text-[#222] rounded-xl shadow-lg border border-gray-200',
            title: 'text-2xl font-bold',
        }
    });
}
</script>
@endpush