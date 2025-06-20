@extends('layouts.app')
@section('title', 'Event Reservations')

@section('content')
    <style>
        body {
            background-color: #131313 !important;
        }
    </style>
    <div class="min-h-screen bg-[#131313] flex flex-col">
        <div class="bg-[#7F160C] py-8 px-10 rounded-b-3xl shadow-lg border-b-4 border-[#E2BB4D]">
            <div class="flex items-center justify-center py-4">
                <div class="bg-[#65090D] px-8 py-4 rounded-2xl shadow-xl border-4 border-[#E2BB4D] flex items-center gap-3">
                    <i class="fa-solid fa-bowl-food text-3xl text-[#E2BB4D] drop-shadow"></i>
                    <span class="text-3xl md:text-4xl font-extrabold tracking-wider text-[#E2BB4D] drop-shadow-lg font-serif">
                        Event Reservations
                    </span>
                </div>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center py-10">
            <div class="w-full max-w-5xl">

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Search Bar --}}
                <div class="mb-4">
                    <form class="relative w-full max-w-md mx-auto" method="GET" action="{{ route('event-reservations.index') }}">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search name or location..."
                            class="w-full py-2 px-4 border-2 border-[#E2BB4D] bg-[#EEEACB] text-[#65090D] rounded-full focus:outline-none focus:ring-2 focus:ring-[#E2BB4D] transition-all duration-300 ease-in-out font-semibold">
                        <button type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-[#E2BB4D] hover:text-[#A67D44] transition-all duration-300 ease-in-out">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-[#E2BB4D] mb-2 font-serif tracking-wider">Event Reservations</h2>
                    <a href="{{ route('event-reservations.create') }}"
                        class="bg-[#E2BB4D] hover:bg-[#A67D44] text-[#65090D] font-bold px-5 py-2 rounded-full shadow flex items-center gap-2 transition-all duration-200 border-2 border-[#A67D44] font-serif">
                        <i class="fa-solid fa-square-plus"></i> Create
                    </a>
                </div>

                <div class="overflow-x-auto rounded-2xl shadow-lg border-4 border-[#E2BB4D] bg-[#65090D]/95">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="bg-[#7F160C] text-[#E2BB4D]">
                                <th class="py-3 px-4 font-bold font-serif">Customer</th>
                                <th class="py-3 px-4 font-bold font-serif">Start Date</th>
                                <th class="py-3 px-4 font-bold font-serif">End Date</th>
                                <th class="py-3 px-4 font-bold font-serif">Pax</th>
                                <th class="py-3 px-4 font-bold font-serif">Total Price</th>
                                <th class="py-3 px-4 font-bold font-serif">Status</th>
                                <th class="py-3 px-4 font-bold font-serif">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations ?? [] as $reservation)
                                <tr class="{{ $loop->even ? 'bg-[#A67D44]/30' : 'bg-[#EEEACB]/10' }} text-[#EEEACB] border-b border-[#E2BB4D]/40">
                                    <td class="py-3 px-4">{{ $reservation->customer_name }}</td>
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($reservation->end_date)->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4">{{ $reservation->pax }}</td>
                                    <td class="py-3 px-4">Rp{{ number_format($reservation->total_price, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 uppercase">{{ $reservation->status }}</td>
                                    <td class="py-3 px-4 text-center flex gap-2 justify-center">
                                        <a href="{{ route('event-reservations.edit', $reservation->id) }}"
                                            class="text-[#E2BB4D] hover:text-[#A67D44] transition-all duration-200" title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('event-reservations.destroy', $reservation->id) }}"
                                            method="POST" onsubmit="return confirm('Delete this reservation?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-all duration-200">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                        <button type="button" onclick='showMenus(@json($reservation->event_menus ?? []))'
                                            class="text-blue-400 hover:text-blue-600 transition-all duration-200" title="View Menus">
                                            <i class="fa-solid fa-list"></i>
                                        </button>
                                        <button type="button" onclick='showAddOns(@json($reservation->event_add_ons ?? []))'
                                            class="text-green-400 hover:text-green-600 transition-all duration-200" title="View AddOns">
                                            <i class="fa-solid fa-puzzle-piece"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-6 text-center text-[#E2BB4D] font-serif">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if ($pagination)
                        <div class="my-8">
                            <nav>
                                <ul class="flex gap-2">
                                    @for ($i = 1; $i <= $pagination->last_page; $i++)
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                                                class="{{ $i == $pagination->current_page ? 'font-bold text-[#E2BB4D]' : 'text-[#EEEACB]' }} font-serif">
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
                    htmlContent += `<div class="mb-3 p-2 border-b border-gray-200">
                        <p class="text-lg font-semibold">
                            🍽️ ${menu.name} - <span class="text-sm text-gray-600">Rp${parseInt(menu.price).toLocaleString('id-ID')}</span>
                        </p>
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

        function showAddOns(addons) {
            let htmlContent = '';
            if (addons.length > 0) {
                htmlContent = '<div class="text-left">';
                addons.forEach(addon => {
                    htmlContent += `<div class="mb-3 p-2 border-b border-gray-200">
                        <p class="text-lg font-semibold">
                            🧩 ${addon.name} - <span class="text-sm text-gray-600">Rp${parseInt(addon.price).toLocaleString('id-ID')}</span>
                        </p>
                    </div>`;
                });
                htmlContent += '</div>';
            } else {
                htmlContent = '<p class="text-gray-500">No addons selected.</p>';
            }

            Swal.fire({
                title: 'Addon List',
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
