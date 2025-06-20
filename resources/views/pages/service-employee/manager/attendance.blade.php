@extends('pages.service-employee.helper.appManager')

@section('title', 'Attendance')
@section('header-title', 'ATTENDANCE')

@section('content')
    <!-- Form -->
    <form method="GET" action="{{ route('manager.attendance') }}" class="max-w-md space-y-6 mb-10" id="filterForm">
        <div>
            <label for="date" class="block mb-1 font-semibold text-[#9b8b8b]">Date</label>
            <input type="date" id="date" name="date"
                   value="{{ request('date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                   class="w-full rounded-md bg-[#f5f8ff] py-3 px-4 text-black font-semibold focus:outline-none focus:ring-2 focus:ring-[#e0a93a]">
        </div>
        <div>
            <label for="shift" class="block mb-1 font-semibold text-[#9b8b8b]">Shift</label>
            <select id="shift" name="shift"
                    class="w-full rounded-md bg-[#f5f8ff] py-3 px-4 text-black font-semibold focus:outline-none focus:ring-2 focus:ring-[#e0a93a]">
                <option value="">Shift</option>
                <option value="day" {{ request('shift') == 'day' ? 'selected' : '' }}>Day 10:00 - 16:00</option>
                <option value="night" {{ request('shift') == 'night' ? 'selected' : '' }}>Night 16:00 - 22:00</option>
            </select>
        </div>
        <div>
            <label for="search" class="block mb-1 font-semibold text-[#9b8b8b]">Search</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search name..."
                   class="w-full rounded-md bg-white border border-[#e0a93a] py-3 px-4 text-black placeholder:text-[#aaa] focus:outline-none focus:ring-2 focus:ring-[#e0a93a]" />
        </div>
        <div>
            <button type="submit"
                    class="bg-[#e0a93a] text-black font-semibold px-6 py-2 rounded-md hover:bg-[#d59d29]">
                Apply Filter
            </button>
        </div>
    </form>

    <!-- Attendance List Title -->
    <h2 class="mt-6 mb-4 text-[#e0a93a] text-2xl font-semibold">Attendance List</h2>

    <!-- Table -->
    <div class="overflow-x-auto max-w-full">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-[#e0a93a] text-black text-sm font-semibold text-left">
                    <th class="py-3 px-4 border border-[#e0a93a]">Name</th>
                    <th class="py-3 px-4 border border-[#e0a93a]">Date</th>
                    <th class="py-3 px-4 border border-[#e0a93a]">Attendance</th>
                    <th class="py-3 px-4 border border-[#e0a93a]">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm font-normal text-black">
                @forelse ($schedules as $schedule)
                    <tr class="bg-[#f5f8ff]">
                        <td class="py-3 px-4 border border-[#e0a93a]">{{ $schedule['name'] }}</td>
                        <td class="py-3 px-4 border border-[#e0a93a]">{{ \Carbon\Carbon::parse($schedule['date'])->format('d/m/Y') }}</td>
                        <td class="py-3 px-4 border border-[#e0a93a]">
                            {{ ucfirst($schedule['shift_type']) }}
                            {{ $schedule['shift_type'] === 'day' ? '10:00 - 16:00' : '16:00 - 22:00' }}
                        </td>
                        <td class="py-3 px-4 border border-[#e0a93a] text-center">
                            <form method="POST" action="{{ route('manager.schedule.update', $schedule['id']) }}">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="note" value="Marked from UI">
                                <input type="hidden" name="attendance" value="0">

                                <input type="checkbox"
                                       name="attendance"
                                       value="1"
                                       onchange="this.form.submit()"
                                       {{ $schedule['attendance'] ? 'checked' : '' }}
                                       aria-label="Attendance checkbox for {{ $schedule['name'] }}">
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 px-4 text-center text-gray-500">No schedule data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Clock Icon -->
    <div class="absolute top-6 right-6 text-[#e0a93a] opacity-90">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#e0a93a"
            stroke-width="2" class="w-32 h-32">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
            <line x1="18" y1="18" x2="22" y2="22" />
            <line x1="22" y1="18" x2="18" y2="22" />
        </svg>
    </div>
@endsection
