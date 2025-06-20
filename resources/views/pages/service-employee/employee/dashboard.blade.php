@extends('pages.service-employee.helper.appEmployee')

@section('title', 'Dashboard')
@section('header-title', 'DASHBOARD')

@section('content')
    <section class="p-10 max-w-screen-xl mx-auto">
        {{-- Shift Summary --}}
        <h2 class="font-playfair text-4xl mb-8">Shift Summary ({{ $currentMonthName }})</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="border border-[#1A1A1A] bg-[#E9E6CC] p-8 flex flex-col items-center space-y-5 rounded-xl shadow-lg">
                <i class="fas fa-calendar-alt text-4xl"></i>
                <div class="text-xl font-sans">Shifts Worked</div>
                <div class="font-sans font-bold text-3xl">{{ $summary['shifts'] }}</div>
            </div>
            <div class="border border-[#1A1A1A] bg-[#E9E6CC] p-8 flex flex-col items-center space-y-5 rounded-xl shadow-lg">
                <i class="fas fa-clock text-4xl"></i>
                <div class="text-xl font-sans">Hours Worked</div>
                <div class="font-sans font-bold text-3xl">{{ $summary['hours'] }} Jam</div>
            </div>
            <div class="border border-[#1A1A1A] bg-[#E9E6CC] p-8 flex flex-col items-center space-y-5 rounded-xl shadow-lg">
                <i class="fas fa-money-bill-wave text-4xl"></i>
                <div class="text-xl font-sans">Salary This Month</div>
                <div class="font-sans font-bold text-3xl">Rp {{ number_format($summary['salary'], 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- Upcoming Schedule --}}
        <h2 class="font-playfair text-4xl mb-8">Upcoming Shifts</h2>

        @if(count($upcomingShifts))
            <div class="space-y-4">
                @foreach($upcomingShifts as $shift)
                    <div class="border border-[#1A1A1A] bg-[#F6F3D7] rounded-lg p-6 shadow-md">
                        <div class="flex justify-between text-lg font-sans mb-1">
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($shift['date'])->format('l, d M Y') }}</span>
                        </div>
                        <p class="text-sm text-gray-700">Role: {{ ucfirst($shift['role']) }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 text-lg font-sans">No upcoming shifts.</p>
        @endif
    </section>
@endsection
