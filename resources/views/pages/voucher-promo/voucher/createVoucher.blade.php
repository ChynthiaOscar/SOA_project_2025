{{-- filepath: resources/views/pages/voucher-promo/voucher/createVoucher.blade.php --}}
@extends('layouts.voucher')

@section('title', 'Tambah Voucher')

@section('content')
<div class="min-h-screen bg-[#EEEACB] flex items-center justify-center py-10">
    <div class="w-full max-w-xl bg-white border-2 border-[#E2BB4D] p-8 shadow" style="box-shadow:0 4px 16px #e2bb4d33;">
        <h2 class="text-2xl font-bold mb-6 text-black uppercase tracking-wider border-b-2 border-[#E2BB4D] pb-2">Tambah Voucher</h2>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-400 text-center">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-400 text-center">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ url('/voucher/store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-1 font-semibold text-black">Kode Voucher</label>
                <input type="text" name="promo_code" placeholder="Kode Voucher" required maxlength="50"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-black">Deskripsi</label>
                <input type="text" name="description" placeholder="Deskripsi" required maxlength="100"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-black">Nilai Voucher</label>
                <input type="number" name="promo_value" placeholder="Nilai Voucher" required
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-black">Status</label>
                <select name="status"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-[#E2BB4D] text-black font-bold py-3 border border-[#E2BB4D] hover:bg-[#d1a53b] transition uppercase">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection