@extends('pages.service-employee.helper.appManager')

@section('title', 'Schedule')

@section('header-title', 'SCHEDULE')

@section('content')
    <section class="flex flex-col items-center py-10 px-8 flex-1">
        <img
            alt="Calendar icon"
            class="mb-4"
            height="120"
            width="120"
            src="https://storage.googleapis.com/a1aa/image/d05bff8a-168b-4535-4542-5059d78126c1.jpg"
        />

        <div class="flex gap-4 mb-10">
            <!-- Single Entry Button -->
            <a href="{{ route('manager.schedule.single.create') }}"
               class="bg-[#d9a93a] text-black font-bold rounded-md px-6 py-2 hover:bg-[#c7771a]">
                Add One Schedule
            </a>

            <!-- Batch Entry Button -->
            <a href="{{ route('manager.schedule.batch.create') }}"
               class="bg-[#d9a93a] text-black font-bold rounded-md px-6 py-2 hover:bg-[#c7771a]">
                Add Batch Schedule
            </a>
        </div>

        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-serif font-bold mb-6 text-black">Filter</h2>

            <!-- Filter Form -->
            <form class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8 items-center" method="GET" action="{{ route('manager.schedule') }}">
                <input
                    type="date"
                    name="date"
                    value="{{ request('date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                    class="bg-white border border-gray-300 text-black text-base px-4 py-2 rounded-sm"
                />

                <select name="shift" class="bg-[#d9a93a] text-[#5f0a0a] text-base px-4 py-2 rounded-sm">
                    <option value="">Shift</option>
                    <option value="day" {{ request('shift') == 'day' ? 'selected' : '' }}>Day</option>
                    <option value="night" {{ request('shift') == 'night' ? 'selected' : '' }}>Night</option>
                </select>

                <select name="role" class="bg-[#d9a93a] text-[#5f0a0a] text-base px-4 py-2 rounded-sm">
                    <option value="">Role</option>
                    <option value="Cashier" {{ request('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                    <option value="Chef" {{ request('role') == 'chef' ? 'selected' : '' }}>Chef</option>
                    <option value="Delivery" {{ request('role') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                    <option value="Waiter" {{ request('role') == 'waiter' ? 'selected' : '' }}>Waiter</option>
                </select>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name..."
                    class="col-span-2 md:col-span-1 bg-white text-black border border-gray-400 px-4 py-2 rounded-sm text-sm"
                />
                <button type="submit"
                        class="bg-[#d6851f] text-black font-semibold px-4 py-2 rounded hover:bg-[#c7771a] col-span-1 md:col-span-1">
                    Apply Filter
                </button>
            </form>

            <!-- Table -->
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#d9a93a] text-[#5f0a0a] font-bold text-left">
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Shift</th>
                        <th class="py-3 px-4">Role</th>
                    </tr>
                </thead>
                <tbody class="bg-[#f7f8ff] text-black font-normal">
                @forelse ($schedules as $schedule)
                    <tr>
                        <td class="py-3 px-4">{{ $schedule['name'] }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($schedule['date'])->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            {{ ucfirst($schedule['shift_type']) }}
                            {{ $schedule['shift_type'] === 'day' ? '10:00 - 16:00' : '16:00 - 22:00' }}
                        </td>
                        <td class="py-3 px-4">{{ $schedule['role'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 px-4 text-center text-gray-500">No data found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
