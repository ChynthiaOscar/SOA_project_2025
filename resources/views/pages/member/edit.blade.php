@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-6xl flex items-center h-auto lg:h-screen flex-wrap mx-auto my-32 lg:my-0 relative">
    <!--Main Col-->
    <div id="profile-edit"
        class="w-full lg:w-2/3 shadow-2xl bg-[#65090D] opacity-95 mx-6 lg:mx-0 border-4 border-[#A67D44]">
        <div class="p-8 md:p-16 text-center lg:text-left">
            <div class="block lg:hidden shadow-xl mx-auto -mt-20 h-56 w-56 bg-cover bg-center border-4 border-[#A67D44]"
                style="background-image: url('https://www.freeiconspng.com/thumbs/profile-icon-png/account-profile-user-icon--icon-search-engine-10.png')"></div>
            <h2 class="text-4xl font-bold pt-10 lg:pt-0 text-[#E2BB4D] mb-6">Edit Profil</h2>
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label for="email" class="block mb-2 font-semibold text-[#E2BB4D] text-lg">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}"
                        class="w-full px-6 py-3 text-[#65090D] bg-white border-2 border-[#A67D44] focus:outline-none focus:ring-2 focus:ring-[#E2BB4D] text-lg" required>
                </div>
                <div>
                    <label for="no_hp" class="block mb-2 font-semibold text-[#E2BB4D] text-lg">No. Telepon</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $member->no_hp) }}"
                        class="w-full px-6 py-3 text-[#65090D] bg-white border-2 border-[#A67D44] focus:outline-none focus:ring-2 focus:ring-[#E2BB4D] text-lg" required>
                </div>
                <div class="flex justify-between mt-10">
                    <a href="{{ url()->previous() }}"
                        class="bg-white text-[#65090D] px-8 py-3 font-semibold hover:bg-gray-100 border-2 border-[#A67D44] text-lg transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#E2BB4D] text-[#65090D] px-8 py-3 font-bold hover:bg-yellow-600 border-2 border-[#A67D44] text-lg transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!--Img Col-->
    <div class="w-full lg:w-1/3 flex justify-center items-center">
        <img src="https://static.thenounproject.com/png/1594252-200.png" class="shadow-2xl hidden lg:block w-[350px] h-[350px] object-cover border-4 border-[#A67D44]">
    </div>
</div>
@endsection
