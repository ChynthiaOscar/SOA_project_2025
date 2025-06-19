@extends('layouts.paymentApp')

@section('title', 'Pembayaran - BCA Virtual Account')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-black px-4 text-[#d4af37] font-sans relative">

    <!-- Back + Title kiri atas -->
    <div class="absolute top-4 left-4 flex items-center space-x-2 text-[#d4af37]">
        <a href="javascript:history.back()" class="text-2xl font-bold hover:underline">
            &larr;
        </a>
        <h1 class="text-xl font-bold border-b-2 border-[#d4af37] px-1">
            PAYMENT
        </h1>
    </div>

    <!-- Metode Pembayaran -->
    <p class="text-sm mb-6 uppercase text-center">Metode Pembayaran : BCA Virtual Account</p>

    <!-- Nama Metode -->
    <div class="font-semibold text-md mb-2 uppercase text-center">BCA Virtual Account</div>

    <!-- VA Number Box -->
    <div class="flex items-center justify-between bg-yellow-400 text-black px-4 py-3 rounded-md w-full max-w-sm mb-6 shadow-md">
        <span id="va-number" class="flex-grow text-center select-text text-lg font-semibold tracking-wide">
            2231243122231286
        </span>
        <button onclick="copyToClipboard()" class="ml-3 hover:text-gray-900 transition" title="Salin">
            <!-- Feather Copy Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2M16 8h2a2 2 0 012 2v8a2 2 0 01-2 2H10a2 2 0 01-2-2v-2" />
            </svg>
        </button>
    </div>

    <!-- Tombol Get Status -->
    <button 
        class="bg-red-800 text-white font-bold px-6 py-2 w-full max-w-sm rounded-md hover:bg-red-700 transition duration-200 tracking-wider">
        GET STATUS
    </button>

</div>
@endsection

@section('scripts')
<script>
    function copyToClipboard() {
        const text = document.getElementById("va-number").textContent;
        navigator.clipboard.writeText(text).then(() => {
            alert("Nomor Virtual Account telah disalin!");
        });
    }
</script>
@endsection
