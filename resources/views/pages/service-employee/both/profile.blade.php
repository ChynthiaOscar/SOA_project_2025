@extends('pages.service-employee.helper.appEmployee')

@section('title', 'Profile Page')

@section('header-title', 'PROFILE')

@section('content')
    <section class="flex flex-col items-center px-6 py-12 space-y-10">
        <img src="https://storage.googleapis.com/a1aa/image/7d2a6816-b1ab-45e2-7d1e-55799aebcc0c.jpg" alt="Portrait"
            class="rounded-full w-28 h-28 object-cover border-4 border-[#D9B54A]" />

        <div class="border border-gray-400 w-full max-w-2xl p-8 bg-[#E9E5C0] rounded-lg shadow-md">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 text-base">
                <p class="font-semibold text-right pr-4">Name:</p>
                <p class="text-left pl-4">{{ session('user.name') ?? '-' }}</p>
                <p class="font-semibold text-right pr-4">Email:</p>
                <p class="text-left pl-4">{{ session('user.email') ?? '-' }}</p>
                <p class="font-semibold text-right pr-4">Role:</p>
                <p class="text-left pl-4">{{ ucfirst(session('user.role')) ?? '-' }}</p>
            </div>
        </div>

        <a href="{{ route('employee.edit') }}"
            class="bg-[#DD8B24] hover:bg-[#c7791a] text-black font-bold text-lg py-3 px-6 rounded w-full max-w-2xl transition text-center block">
            Edit Profile
        </a>
        </a>
    </section>
@endsection
