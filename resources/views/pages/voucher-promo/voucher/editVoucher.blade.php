@extends('layouts.voucher')

@section('title', 'Edit Voucher')

@section('content')
<div class="min-h-screen bg-[#EEEACB] flex items-center justify-center py-10">
    <div class="w-full max-w-xl rounded-lg p-8 shadow-lg" style="background-color: #f5edcc;">
        <a href="{{ route('promoHome') }}" class="inline-block mb-6">
            <button type="button" class="bg-gray-200 hover:bg-[#E2BB4D] text-black font-semibold px-4 py-2 rounded border border-[#E2BB4D] transition">
                &larr; Kembali
            </button>
        </a>
        <h2 class="text-2xl font-bold mb-8 text-black text-center uppercase tracking-wider">Edit Voucher</h2>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-400 text-center rounded">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-400 text-center rounded">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('vouchers.update', $voucher['id']) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-black">Kode Voucher</label>
                <input type="text" name="promo_code" placeholder="Kode Voucher" required maxlength="50"
                    value="{{ old('promo_code', $voucher['promo_code']) }}"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-black">Deskripsi</label>
                <input type="text" name="description" placeholder="Deskripsi" required maxlength="100"
                    value="{{ old('description', $voucher['description']) }}"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-black">Nilai Voucher</label>
                <input type="number" name="promo_value" placeholder="Nilai Voucher" required
                    value="{{ old('promo_value', $voucher['promo_value']) }}"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div class="mb-6">
                <label class="block mb-1 font-semibold text-black">Status</label>
                <select name="status"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
                    <option value="1" {{ old('status', $voucher['status']) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $voucher['status']) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#E2BB4D] text-black font-bold px-8 py-2 rounded border border-[#E2BB4D] hover:bg-[#d1a53b] transition uppercase shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection