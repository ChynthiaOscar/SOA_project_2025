@extends('layouts.paymentApp')

@section('title', 'Pembayaran - OVO')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-black px-4 text-[#d4af37] font-sans">

    {{-- tombol batal payment --}}
    <div class="absolute top-4 left-4 flex items-center space-x-2 text-[#d4af37]">
        <button 
            onclick="cancelPayment()"
            id="cancel-btn"
            disabled
            class="text-2xl flex flex-row items-center font-bold space-x-2 focus:outline-none">
            <span>&larr;</span>
            <h1 class="text-xl font-bold border-b-2 border-[#d4af37] px-1">
                PAYMENT
            </h1>
        </button>
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
            id="get-status-btn"
            onclick="checkPaymentStatus()"
            class="mt-4 bg-red-800 text-white font-bold px-6 py-2 w-full rounded-md hover:bg-red-700 transition duration-200 tracking-wider">
            GET STATUS
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    const paymentData = {
        customer_id: 1234567890,
        requester_type: 2,
        requester_id: 212,
        secondary_requester_id: null,
        payment_method: "ovo",
        payment_amount: 10000
    };

    // hardcode
    
    // const paymentData = {
    //     customer_id: 1234567890,
    //     requester_type: 2,
    //     requester_id: 212,
    //     secondary_requester_id: null,
    //     payment_method: "ovo",
    //     payment_amount: 10000
    // };

    let currentPaymentId = null;

    function generateQR() {
        fetch("{{ route('payment.ovo.generate') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(paymentData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('qr-image').src = data.qr_url;
                document.getElementById('qr-container').classList.remove('hidden');


                currentPaymentId = data.payment_id;
            } else {
                alert("Gagal generate QR: " + data.message);
            }
        })
        .catch(error => {
            console.error(error);
            alert("Terjadi kesalahan saat menghubungi server (mungkin server lagi down).");
        });
    }


    function cancelPayment() {
        if (!currentPaymentId) {
            alert("Belum ada pembayaran yang dibuat.");
            return;
        }

        fetch("{{ route('payment.cancel') }}", {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                payment_id: currentPaymentId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                // Reset tampilan
                currentPaymentId = null;
                document.getElementById('cancel-btn').disabled = true;
                document.getElementById('qr-container').classList.add('hidden');
            } else {
                alert("Gagal: " + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi error saat membatalkan pembayaran.");
        });
    }


    function checkPaymentStatus() {

        const redirectUrl = "{{ route('payment.success') }}";

        if (!currentPaymentId) {
            alert("Belum ada pembayaran yang dibuat.");
            return;
        }

        fetch(`/payment/${currentPaymentId}/check-status`) // pastikan route ini tersedia
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("✅ Pembayaran berhasil!");
                    document.getElementById('cancel-btn').disabled = true;
                    window.location.href = redirectUrl;
                } else if (data.status === 'pending') {
                    alert("⌛ Pembayaran masih menunggu.");
                } else if (data.status === 'cancelled') {
                    alert("❌ Pembayaran dibatalkan.");
                    document.getElementById('cancel-btn').disabled = true;
                } else {
                    alert("⚠️ Status tidak dikenali.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Gagal memeriksa status pembayaran.");
            });
    }
</script>
@endsection
