@extends('helper.appManager')

@section('title', 'Employee Data')

@section('header-title', 'Employee Data')

@section('content')
    <h2 class="text-2xl font-semibold mb-2">Search Employees</h2>
    <p class="text-base text-gray-700 mb-6 max-w-md">
        Find employees by ID and filters by parameters
    </p>

    <!-- Search Input -->
    <form class="mb-8 max-w-xl">
        <label class="sr-only" for="search">Search</label>
        <div class="relative">
            <input
                class="w-full rounded-lg py-3 pl-12 pr-6 text-base font-medium text-black placeholder-gray-500 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#d1a72f]"
                id="search" placeholder="Search" type="search" />
            <i
                class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg"></i>
        </div>
    </form>

    <!-- Role Button -->
    <div class="mb-10 relative inline-block text-left">
        <button id="roleButton"
            class="bg-[#d1a72f] text-black font-semibold text-sm px-5 py-2 rounded hover:bg-[#c89b2c] transition-colors duration-200 flex items-center space-x-2"
            type="button" onclick="toggleDropdown()">
            <span>Role</span>
            <i class="fas fa-chevron-down text-sm"></i>
        </button>

        <!-- Dropdown Menu -->
        <div id="roleDropdown"
            class="hidden absolute mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
            <div class="py-1 text-sm text-black">
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Chef</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Cashier</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delivery</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Waiter</a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base text-left text-black bg-white shadow border border-gray-200">
            <thead class="bg-black text-white text-sm uppercase">
                <tr>
                    <th class="py-4 px-6">ID</th>
                    <th class="py-4 px-6">Name</th>
                    <th class="py-4 px-6">Date</th>
                    <th class="py-4 px-6">Shift</th>
                    <th class="py-4 px-6">Attendance</th>
                    <th class="py-4 px-6">Role</th>
                    <th class="py-4 px-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-gray-200 text-lg">
                    <td class="py-4 px-6 font-normal">1</td>
                    <td class="py-4 px-6 font-normal">Bima</td>
                    <td class="py-4 px-6 font-normal">23/05/2025</td>
                    <td class="py-4 px-6 font-normal">Day</td>
                    <td class="py-4 px-6 font-normal">Present</td>
                    <td class="py-4 px-6 font-normal">Cashier</td>
                    <td class="py-4 px-6 font-normal flex space-x-4">
                        <button aria-label="Edit Bima" class="text-[#d1a72f] hover:text-yellow-400 text-xl">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button aria-label="Delete Bima" class="text-red-700 hover:text-red-900 text-xl">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr class="border-t border-gray-200 text-lg">
                    <td class="py-4 px-6 font-normal">2</td>
                    <td class="py-4 px-6 font-normal">Sari</td>
                    <td class="py-4 px-6 font-normal">22/05/2025</td>
                    <td class="py-4 px-6 font-normal">Night</td>
                    <td class="py-4 px-6 font-normal">Absent</td>
                    <td class="py-4 px-6 font-normal">Chef</td>
                    <td class="py-4 px-6 font-normal flex space-x-4">
                        <button aria-label="Edit Sari" class="text-[#d1a72f] hover:text-yellow-400 text-xl">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button aria-label="Delete Sari" class="text-red-700 hover:text-red-900 text-xl">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr class="border-t border-gray-200 text-lg">
                    <td class="py-4 px-6 font-normal">3</td>
                    <td class="py-4 px-6 font-normal">Rizky</td>
                    <td class="py-4 px-6 font-normal">21/05/2025</td>
                    <td class="py-4 px-6 font-normal">Day</td>
                    <td class="py-4 px-6 font-normal">Present</td>
                    <td class="py-4 px-6 font-normal">Delivery</td>
                    <td class="py-4 px-6 font-normal flex space-x-4">
                        <button aria-label="Edit Rizky" class="text-[#d1a72f] hover:text-yellow-400 text-xl">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button aria-label="Delete Rizky" class="text-red-700 hover:text-red-900 text-xl">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr class="border-t border-gray-200 text-lg">
                    <td class="py-4 px-6 font-normal">4</td>
                    <td class="py-4 px-6 font-normal">Dewi</td>
                    <td class="py-4 px-6 font-normal">20/05/2025</td>
                    <td class="py-4 px-6 font-normal">Night</td>
                    <td class="py-4 px-6 font-normal">Present</td>
                    <td class="py-4 px-6 font-normal">Waiter</td>
                    <td class="py-4 px-6 font-normal flex space-x-4">
                        <button aria-label="Edit Dewi" class="text-[#d1a72f] hover:text-yellow-400 text-xl">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button aria-label="Delete Dewi" class="text-red-700 hover:text-red-900 text-xl">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr class="border-t border-gray-200 text-lg">
                    <td class="py-4 px-6 font-normal">5</td>
                    <td class="py-4 px-6 font-normal">Andi</td>
                    <td class="py-4 px-6 font-normal">19/05/2025</td>
                    <td class="py-4 px-6 font-normal">Day</td>
                    <td class="py-4 px-6 font-normal">Present</td>
                    <td class="py-4 px-6 font-normal">Chef</td>
                    <td class="py-4 px-6 font-normal flex space-x-4">
                        <button aria-label="Edit Andi" class="text-[#d1a72f] hover:text-yellow-400 text-xl">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button aria-label="Delete Andi" class="text-red-700 hover:text-red-900 text-xl">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("roleDropdown");
            dropdown.classList.toggle("hidden");
        }

        window.addEventListener("click", function (e) {
            const button = document.getElementById("roleButton");
            const dropdown = document.getElementById("roleDropdown");
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });
    </script>
@endsection
