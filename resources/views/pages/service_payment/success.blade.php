@extends('layouts.paymentApp')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-black px-4 text-[#d4af37] font-sans relative">


    <!-- Icon Success -->
    <div class="flex flex-col items-center mt-12">
        <img src="{{ asset('assets/success.gif') }}" alt="Success Animation" class="w-32 h-32 mb-6" />
        <h2 class="text-xl font-bold uppercase tracking-wider text-[#d4af37]">Payment Berhasil</h2>
    </div>

    <!-- Tombol kembali ke home -->
    <a href="{{ url('/') }}"
       class="mt-10 bg-red-800 text-white font-semibold px-6 py-2 w-full max-w-sm text-center rounded-md hover:bg-red-700 transition duration-200 tracking-wider">
        BACK TO HOME
    </a>

</div>
@endsection
