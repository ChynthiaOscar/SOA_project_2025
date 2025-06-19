@extends('pages.service-employee.helper.appEmployee')

@section('title', 'Edit Profile Page')

@section('header-title', 'EDIT PROFILE')

@section('content')
    <section class="flex flex-col items-center px-6 py-12 space-y-10">
        <!-- Profile Image Section -->
        <div class="flex flex-col items-center space-y-4">
            <img
                src="https://storage.googleapis.com/a1aa/image/7d2a6816-b1ab-45e2-7d1e-55799aebcc0c.jpg"
                alt="Portrait"
                class="rounded-full w-28 h-28 object-cover border-4 border-[#D9B54A]"
                id="profile-image"
            />
            <button
                type="button"
                class="bg-[#D9B54A] hover:bg-[#c7a43a] text-black font-medium text-sm py-2 px-4 rounded transition"
                onclick="document.getElementById('image-upload').click()"
            >
                Change Photo
            </button>
            <input type="file" id="image-upload" accept="image/*" class="hidden" onchange="previewImage(event)">
        </div>

        <!-- Edit Form -->
        {{-- <form class="border border-gray-400 w-full max-w-2xl p-8 bg-[#E9E5C0] rounded-lg shadow-md" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"> --}}
        <form
            method="POST"
            action="{{ url('api/employee/' . ($user['id'] ?? '')) }}"
            enctype="multipart/form-data"
            class="border border-gray-400 w-full max-w-2xl p-8 bg-[#E9E5C0] rounded-lg shadow-md"
            id="profile-form"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-y-6 text-base">
                <!-- Name Field -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:gap-y-0 items-center">
                    <label for="name" class="font-semibold text-right sm:pr-4">Name:</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user['name'] ?? 'Alex') }}"
                        class="text-left sm:pl-4 p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#D9B54A] focus:border-transparent bg-white"
                        required
                    >
                </div>

                <!-- Email Field -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:gap-y-0 items-center">
                    <label for="email" class="font-semibold text-right sm:pr-4">Email:</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user['email'] ?? 'Alex@gmail.com') }}"
                        class="text-left sm:pl-4 p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#D9B54A] focus:border-transparent bg-white"
                        required
                    >
                </div>

                <!-- Role Field (Read Only) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:gap-y-0 items-center">
                    <label for="role" class="font-semibold text-right sm:pr-4">Role:</label>
                    <input
                        type="text"
                        id="role"
                        name="role"
                        value="{{ $user['role'] ?? 'Cashier' }}"
                        class="text-left sm:pl-4 p-3 border border-gray-300 rounded-md bg-gray-100 text-gray-600"
                        readonly
                    >
                </div>

                <!-- Password Field (Optional) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:gap-y-0 items-center">
                    <label for="password" class="font-semibold text-right sm:pr-4">New Password:</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Leave blank to keep current password"
                        class="text-left sm:pl-4 p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#D9B54A] focus:border-transparent bg-white"
                    >
                </div>

                <!-- Confirm Password Field -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:gap-y-0 items-center">
                    <label for="password_confirmation" class="font-semibold text-right sm:pr-4">Confirm Password:</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        class="text-left sm:pl-4 p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#D9B54A] focus:border-transparent bg-white"
                    >
                </div>
            </div>

            <!-- Hidden input for profile image -->
            <input type="hidden" name="profile_image" id="profile-image-data">

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 w-full max-w-2xl mt-8">
                <button
                    type="submit"
                    class="bg-[#DD8B24] hover:bg-[#c7791a] text-black font-bold text-lg py-3 px-6 rounded flex-1 transition"
                >
                    Save Changes
                </button>
                <a
                    href="{{ url()->previous() }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold text-lg py-3 px-6 rounded flex-1 transition text-center"
                >
                    Cancel
                </a>
            </div>
        </form>
    </section>

    <!-- JavaScript for Image Preview -->
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-image').src = e.target.result;
                    document.getElementById('profile-image-data').value = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');

            form.addEventListener('submit', function(e) {
                if (password.value && password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    confirmPassword.focus();
                }
            });
        });
    </script>
@endsection
