@extends('helper.appManager')

@section('title', 'Attendance')
@section('header-title', 'ATTENDANCE')

@section('content')
    <!-- Form -->
    <form class="max-w-md space-y-6 mb-10">
        <div>
            <label for="name" class="block mb-1 font-semibold text-[#9b8b8b]">Name</label>
            <select id="name" name="name"
                class="w-full rounded-md bg-[#f5f8ff] border border-transparent py-3 px-4 text-black font-semibold focus:outline-none focus:ring-2 focus:ring-[#e0a93a]">
                <option>Name</option>
                <option>Alex</option>
                <option>Jonathan</option>
                <option>Budi</option>
            </select>
        </div>
        <div>
            <label for="date" class="block mb-1 font-semibold text-[#9b8b8b]">Date</label>
            <select id="date" name="date"
                class="w-full rounded-md bg-[#f5f8ff] border border-transparent py-3 px-4 text-black font-semibold focus:outline-none focus:ring-2 focus:ring-[#e0a93a]">
                <option>Date</option>
                <option>25/05/2025</option>
                <option>26/05/2025</option>
            </select>
        </div>
        <div>
            <label for="shift" class="block mb-1 font-semibold text-[#9b8b8b]">Shift</label>
            <select id="shift" name="shift"
                class="w-full rounded-md bg-[#f5f8ff] border border-transparent py-3 px-4 text-black font-semibold focus:outline-none focus:ring-2 focus:ring-[#e0a93a]">
                <option>Shift</option>
                <option>Day 10:00 - 16:00</option>
                <option>Night 16:00 - 22:00</option>
            </select>
        </div>
        <div>
            <label for="searchInput" class="block mb-1 font-semibold text-[#9b8b8b]">Search</label>
            <input type="text" id="searchInput" name="searchInput" placeholder="Search name..."
                class="w-full rounded-md bg-white border border-[#e0a93a] py-3 px-4 text-black placeholder:text-[#aaa] focus:outline-none focus:ring-2 focus:ring-[#e0a93a]" />
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
                <tr class="bg-[#f5f8ff]">
                    <td class="py-3 px-4 border border-[#e0a93a]">Alex</td>
                    <td class="py-3 px-4 border border-[#e0a93a]">25/05/2025</td>
                    <td class="py-3 px-4 border border-[#e0a93a]">Day 10:00 - 16:00</td>
                    <td class="py-3 px-4 border border-[#e0a93a] text-center">
                        <input type="checkbox" aria-label="Attendance checkbox for Alex" />
                    </td>
                </tr>
                <tr class="bg-[#f5f8ff]">
                    <td class="py-3 px-4 border border-[#e0a93a]">Jonathan</td>
                    <td class="py-3 px-4 border border-[#e0a93a]">25/05/2025</td>
                    <td class="py-3 px-4 border border-[#e0a93a]">Night 16:00 - 22:00</td>
                    <td class="py-3 px-4 border border-[#e0a93a] text-center">
                        <input type="checkbox" checked aria-label="Attendance checkbox for Jonathan" />
                    </td>
                </tr>
                <tr class="bg-[#f5f8ff]">
                    <td class="py-3 px-4 border border-[#e0a93a]">Budi</td>
                    <td class="py-3 px-4 border border-[#e0a93a]">26/05/2025</td>
                    <td class="py-3 px-4 border border-[#e0a93a]">Day 10:00 - 16:00</td>
                    <td class="py-3 px-4 border border-[#e0a93a] text-center">
                        <input type="checkbox" aria-label="Attendance checkbox for Budi" />
                    </td>
                </tr>
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
