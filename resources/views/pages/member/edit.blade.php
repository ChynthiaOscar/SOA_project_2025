@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-[#1E1E1E] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-4xl bg-[#65090D] shadow-2xl border border-[#A67D44] p-8 md:p-12 text-white">

        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            {{-- Avatar --}}
            <div class="w-32 h-32 md:w-40 md:h-40 border-4 rounded-full border-[#E2BB4D] bg-center bg-cover shadow-lg"
                 style="background-image: url('https://www.freeiconspng.com/thumbs/profile-icon-png/account-profile-user-icon--icon-search-engine-10.png')">
            </div>

            {{-- Form --}}
            <div class="flex-1 w-full">
                <h2 class="text-3xl font-bold text-[#E2BB4D] mb-8">Edit Profil</h2>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block mb-2 text-lg font-semibold text-[#E2BB4D]">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $member['email']) }}"
                            class="w-full px-5 py-3 bg-[#EEEACB] text-[#65090D] border-2 border-[#A67D44] focus:outline-none focus:ring-2 focus:ring-[#E2BB4D] text-lg"
                            required>
                    </div>

                    <div>
                        <label for="no_hp" class="block mb-2 text-lg font-semibold text-[#E2BB4D]">No. Telepon</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $member['no_hp']) }}"
                            class="w-full px-5 py-3 bg-[#EEEACB] text-[#65090D] border-2 border-[#A67D44] focus:outline-none focus:ring-2 focus:ring-[#E2BB4D] text-lg"
                            required>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-end mt-10">
                        <a href="{{ url()->previous() }}"
                            class="bg-white text-[#65090D] hover:bg-gray-100 font-semibold rounded-full px-6 py-3 border-2 border-[#A67D44] transition text-sm sm:text-base">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-[#E2BB4D] text-[#65090D] hover:bg-yellow-600 rounded-full hover:text-white font-bold px-6 py-3 border-2 border-[#A67D44] transition text-sm sm:text-base">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
