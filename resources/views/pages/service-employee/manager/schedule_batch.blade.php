@extends('pages.service-employee.helper.appManager')

@section('title', 'Add Batch Schedule')
@section('header-title', 'Add Batch Schedule')

@section('content')
    <form method="POST" action="{{ route('manager.schedule.batch.store') }}" class="max-w-lg space-y-6">
        @csrf

        <div>
            <label for="employee_ids" class="block font-medium">Select Employees</label>
            <select id="employee_ids" name="employee_ids[]" multiple required class="w-full border border-gray-300 p-3 rounded h-40">
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
            Submit Batch
        </button>
    </form>
@endsection
