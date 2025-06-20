@extends('pages.service-employee.helper.appManager')

@section('title', 'Add Schedule')
@section('header-title', 'Add One Schedule')

@section('content')
    <form method="POST" action="{{ route('manager.schedule.single.store') }}" class="max-w-lg space-y-6">
        @csrf

        <div>
            <label for="employee_id" class="block font-medium">Employee</label>
            <select id="employee_id" name="employee_id" required class="w-full border border-gray-300 p-3 rounded">
                @foreach($employees as $emp)
                    <option value="{{ $emp['id'] }}">{{ $emp['name'] }} ({{ $emp['role'] ?? 'Unassigned' }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="date" class="block font-medium">Date</label>
            <input type="date" id="date" name="date" value="{{ now()->format('Y-m-d') }}" required
                   class="w-full border border-gray-300 p-3 rounded" />
        </div>

        <div>
            <label for="shift_type" class="block font-medium">Shift</label>
            <select id="shift_type" name="shift_type" required class="w-full border border-gray-300 p-3 rounded">
                <option value="day">Day</option>
                <option value="night">Night</option>
            </select>
        </div>

        <button type="submit" class="bg-[#d1a72f] text-black font-semibold py-2 px-4 rounded hover:bg-[#c89b2c]">
            Submit
        </button>
    </form>
@endsection
