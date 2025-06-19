@extends('layouts.paymentApp')

@section('title', 'Pembayaran - OVO')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-black px-4 text-[#d4af37] font-sans">

    <div class="absolute top-4 left-4 flex items-center space-x-2 text-[#d4af37] ">
        <a href="#" class="text-2xl flex flex-row font-bold">
            &larr;
            <h1 class="text-xl font-bold border-b-2 border-[#d4af37] px-1">
                PAYMENT
            </h1>
        </a>
    </div>  

    <p class="text-sm mb-6 uppercase text-center">Metode Pembayaran : OVO</p>

    <!-- Tombol Generate QR -->
    <button 
        id="generate-btn"
        onclick="generateQR()"
        class="bg-red-800 text-white font-bold px-6 py-2 w-full max-w-sm rounded-md hover:bg-red-700 transition duration-200 mb-6">
        GENERATE QR CODE
    </button>

    <!-- QR & Get Status -->
    <div id="qr-container" class="hidden flex flex-col w-full max-w-sm items-center">
        <img id="qr-image" src="" alt="QR Code" class="bg-yellow-300 p-4 rounded max-w-xs" />

        <button 
            class="mt-6 bg-red-800 text-white font-bold px-6 py-2 w-full max-w-sm rounded-md hover:bg-red-700 transition duration-200">
            GET STATUS
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function generateQR() {
        fetch("{{ route('payment.ovo.generate') }}")
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('qr-image').src = data.qr_url;
                    document.getElementById('qr-container').classList.remove('hidden');

                } else {
                    alert("Gagal generate QR");
                }
            })
            .catch(error => {
                console.error(error);
                alert("Terjadi kesalahan saat menghubungi server.");
            });
    }
</script>
@endsection
