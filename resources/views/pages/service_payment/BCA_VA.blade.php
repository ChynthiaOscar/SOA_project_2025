@extends('layouts.paymentApp')

@section('title', 'Pembayaran - BCA Virtual Account')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-black px-4 text-[#d4af37] font-sans relative">

    <!-- Back + Title kiri atas -->
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

    <!-- Metode Pembayaran -->
    <p class="text-sm mb-6 uppercase text-center">Metode Pembayaran : BCA Virtual Account</p>

    <!-- Nama Metode -->
    <div class="font-semibold text-md mb-2 uppercase text-center">BCA Virtual Account</div>

    <!-- Tombol Generate VA -->
    <button id="generate-va-btn"
        onclick="generateVA()"
        class="bg-blue-600 text-white font-bold px-6 py-2 w-full max-w-sm rounded-md hover:bg-blue-500 transition duration-200 tracking-wider mb-6">
        Generate BCA Virtual Account
    </button>

    <!-- VA Box -->
    <div id="va-box" class="hidden flex-col items-center justify-between w-full max-w-sm mb-6">
        <div class="flex items-center justify-between bg-yellow-400 text-black px-4 py-3 rounded-md shadow-md w-full">
            <span id="va-number" class="flex-grow text-center select-text text-lg font-semibold tracking-wide">
                <!-- VA Number akan diisi dengan JS -->
            </span>
            <button onclick="copyToClipboard()" class="ml-3 hover:text-gray-900 transition" title="Salin">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2M16 8h2a2 2 0 012 2v8a2 2 0 01-2 2H10a2 2 0 01-2-2v-2" />
                </svg>
            </button>
        </div>

        <!-- Tombol Get Status -->
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
    const paymentData = {
        customer_id: {{ $customer_id }},
        requester_type: {{ $requester_type }},
        requester_id: {{ $requester_id }},
        secondary_requester_id: {{ $secondary_requester_id }},
        payment_method: "bca_va",
        payment_amount: {{ $payment_amount }}
    };

    let currentPaymentId = null;

    function copyToClipboard() {
        const text = document.getElementById("va-number").textContent;
        navigator.clipboard.writeText(text).then(() => {
            alert("Nomor Virtual Account telah disalin!");
        });
    }

    function generateVA() {
        fetch("{{ route('payment.bca.generate') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(paymentData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('va-number').textContent = data.va_number;
                document.getElementById('va-box').classList.remove('hidden');
                document.getElementById('generate-va-btn').classList.add('hidden');

                currentPaymentId = data.payment_id;
                document.getElementById('cancel-btn').disabled = false;
            } else {
                alert("Gagal generate VA: " + data.message);
            }
        })
        .catch(error => {
            console.error(error);
            alert("Terjadi kesalahan saat menghubungi server.");
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
                currentPaymentId = null;
                document.getElementById('cancel-btn').disabled = true;
                document.getElementById('va-box').classList.add('hidden');
                document.getElementById('generate-va-btn').classList.remove('hidden');
            } else {
                alert("Gagal generate BCA virtual account: " + data.message);
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
