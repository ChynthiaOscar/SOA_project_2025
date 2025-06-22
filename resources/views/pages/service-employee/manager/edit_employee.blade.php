@extends('pages.service-employee.helper.appManager')

@section('title', 'Edit Employee')
@section('header-title', 'Edit Employee')

@section('content')
    <form method="POST" action="{{ route('manager.employee.update', $employee['id'])  }}" class="space-y-6 max-w-xl" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-medium">Name</label>
            <input id="name" name="name" value="{{ old('name', $employee['name']) }}" required
                   class="w-full border border-gray-300 p-3 rounded">
        </div>

        <div>
            <label for="role" class="block font-medium">Role</label>
            <select id="role" name="role" required class="w-full border border-gray-300 p-3 rounded">
                <option value="" {{ empty($employee['role']) ? 'selected' : '' }}>Unassigned</option>
                <option value="Cashier" {{ $employee['role'] === 'cashier' ? 'selected' : '' }}>Cashier</option>
                <option value="Chef" {{ $employee['role'] === 'chef' ? 'selected' : '' }}>Chef</option>
                <option value="Delivery" {{ $employee['role'] === 'delivery' ? 'selected' : '' }}>Delivery</option>
                <option value="Waiter" {{ $employee['role'] === 'waiter' ? 'selected' : '' }}>Waiter</option>
            </select>
        </div>

        <div>
            <label for="salary_per_shift" class="block font-medium">Salary per Shift</label>
            <input id="salary_per_shift" name="salary_per_shift" type="number"
                   value="{{ old('salary_per_shift', $employee['salary_per_shift']) }}"
                   class="w-full border border-gray-300 p-3 rounded" required>
        </div>

        <button type="submit"
                class="bg-[#d1a72f] text-black font-semibold py-2 px-4 rounded hover:bg-[#c89b2c]">
            Update Employee
        </button>
    </form>
@endsection
