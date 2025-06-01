@extends('helper.appEmployee')

@section('title', 'Dashboard')
@section('header-title', 'DASHBOARD')

@section('content')
    <section class="p-10 max-w-screen-xl mx-auto">
        <h2 class="font-playfair text-4xl mb-8">Performance Report</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="border border-[#1A1A1A] bg-[#E9E6CC] p-8 flex flex-col items-center space-y-5 rounded-xl shadow-lg">
                <i class="fas fa-cloud text-4xl"></i>
                <div class="text-xl font-sans">Number of Shift</div>
                <div class="font-sans font-bold text-3xl">18</div>
            </div>
            <div class="border border-[#1A1A1A] bg-[#E9E6CC] p-8 flex flex-col items-center space-y-5 rounded-xl shadow-lg">
                <i class="fas fa-dollar-sign text-4xl"></i>
                <div class="text-xl font-sans">Salary per Month</div>
                <div class="font-sans font-bold text-3xl">Rp 2.500.000</div>
            </div>
            <div class="border border-[#1A1A1A] bg-[#E9E6CC] p-8 flex flex-col items-center space-y-5 rounded-xl shadow-lg">
                <i class="fas fa-dollar-sign text-4xl"></i>
                <div class="text-xl font-sans">Total Salary</div>
                <div class="font-sans font-bold text-3xl">Rp 45.000.000</div>
            </div>
        </div>

        <h2 class="font-playfair text-4xl mb-8">Report per Month</h2>

        <div class="grid grid-cols-3 gap-6 text-lg font-sans font-semibold mb-4 py-3 border-b border-[#1A1A1A]">
            <div>Month</div>
            <div>Number of Shifts</div>
            <div>Total Salary</div>
        </div>

        <div class="grid grid-cols-3 gap-6 text-lg font-sans mb-3 py-3">
            <div>January</div>
            <div>10</div>
            <div>Rp 25.000.000</div>
        </div>
        <div class="grid grid-cols-3 gap-6 text-lg font-sans mb-3 py-3">
            <div>February</div>
            <div>8</div>
            <div>Rp 20.000.000</div>
        </div>
        <div class="grid grid-cols-3 gap-6 text-lg font-sans py-3">
            <div>March</div>
            <div>4</div>
            <div>Rp 15.000.000</div>
        </div>
    </section>
@endsection
