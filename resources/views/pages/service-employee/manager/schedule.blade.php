@extends('helper.appManager')

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

        <button
            class="bg-[#d6851f] text-black font-bold rounded-md px-6 py-2 mb-10"
            type="button"
        >
            Add Shift
        </button>

        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-serif font-bold mb-6 text-black">Shift</h2>

            <!-- Filter Form -->
            <form
                class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8 items-center"
                onsubmit="event.preventDefault()"
            >
                <select
                    class="bg-[#d9a93a] text-[#5f0a0a] text-base px-4 py-2 rounded-sm"
                    aria-label="Date"
                >
                    <option>Date</option>
                    <option>25/05/2025</option>
                    <option>26/05/2025</option>
                </select>

                <select
                    class="bg-[#d9a93a] text-[#5f0a0a] text-base px-4 py-2 rounded-sm"
                    aria-label="Shift"
                >
                    <option>Shift</option>
                    <option>Day 10:00 - 16:00</option>
                    <option>Night 16:00 - 22:00</option>
                </select>

                <select
                    class="bg-[#d9a93a] text-[#5f0a0a] text-base px-4 py-2 rounded-sm"
                    aria-label="Role"
                >
                    <option>Role</option>
                    <option>Cashier</option>
                    <option>Chef</option>
                    <option>Delivery</option>
                </select>

                <input
                    type="text"
                    placeholder="Search name..."
                    class="col-span-2 md:col-span-1 bg-white text-black border border-gray-400 px-4 py-2 rounded-sm text-sm"
                />
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
                    <tr>
                        <td class="py-3 px-4">Alex</td>
                        <td class="py-3 px-4">25/05/2025</td>
                        <td class="py-3 px-4">Day 10:00 - 16:00</td>
                        <td class="py-3 px-4">Cashier</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4">Jonathan</td>
                        <td class="py-3 px-4">25/05/2025</td>
                        <td class="py-3 px-4">Night 16:00 - 22:00</td>
                        <td class="py-3 px-4">Chef</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4">Budi</td>
                        <td class="py-3 px-4">26/05/2025</td>
                        <td class="py-3 px-4">Day 10:00 - 16:00</td>
                        <td class="py-3 px-4">Delivery</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
