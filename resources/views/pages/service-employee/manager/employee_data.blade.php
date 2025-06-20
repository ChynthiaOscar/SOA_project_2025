@extends('pages.service-employee.helper.appManager')

@section('title', 'Manage Employee')

@section('header-title', 'Manage Employee')

@section('content')
    <h2 class="text-2xl font-semibold mb-2">Search Employees</h2>

    <!-- Search Input -->
    <form method="GET" action="{{ route('manager.employee_data') }}" class="mb-8 max-w-xl space-y-4">
        <div class="relative">
            <input
                name="search"
                value="{{ request('search') }}"
                class="w-full rounded-lg py-3 pl-12 pr-6 text-base font-medium text-black placeholder-gray-500 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#d1a72f]"
                placeholder="Search"
                type="search" />
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg"></i>
        </div>

        <select name="role" class="border border-gray-300 p-2 rounded-md bg-white">
            <option value="">All Roles</option>
            <option value="Chef" {{ request('role') == 'chef' ? 'selected' : '' }}>Chef</option>
            <option value="Cashier" {{ request('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
            <option value="Delivery" {{ request('role') == 'delivery' ? 'selected' : '' }}>Delivery</option>
            <option value="Waiter" {{ request('role') == 'waiter' ? 'selected' : '' }}>Waiter</option>
        </select>

        <button type="submit" class="bg-[#d1a72f] px-4 py-2 rounded hover:bg-[#c89b2c] transition">Filter</button>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base text-left text-black bg-white shadow border border-gray-200">
            <thead class="bg-black text-white text-sm uppercase">
            <tr>
                <th class="py-4 px-6">ID</th>
                <th class="py-4 px-6">Name</th>
                <th class="py-4 px-6">Role</th>
                <th class="py-4 px-6">Salary per Shift</th>
                <th class="py-4 px-6">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($employees as $emp)
                <tr class="border-t border-gray-200 text-lg">
                    <td class="py-4 px-6 font-normal">{{ $emp['id'] }}</td>
                    <td class="py-4 px-6 font-normal">{{ $emp['name'] }}</td>
                    <td class="py-4 px-6 font-normal">{{ $emp['role'] }}</td>
                    <td class="py-4 px-6 font-normal">{{ $emp['salary_per_shift'] }}</td>
                    <td class="py-4 px-6 font-normal flex space-x-4">
                        <a href="{{ route('manager.employee.edit', $emp['id']) }}" class="text-[#d1a72f] hover:text-yellow-400 text-xl" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
{{--                        <form action="#" method="POST" onsubmit="return confirm('Delete this user?')">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" class="text-red-700 hover:text-red-900 text-xl" title="Delete">--}}
{{--                                <i class="fas fa-trash-alt"></i>--}}
{{--                            </button>--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">No employees found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
