@extends('layouts.voucher')

@section('title', 'Tambah Promo')

@section('content')
<div class="min-h-screen bg-[#EEEACB] flex items-center justify-center py-10">
    <div class="w-full max-w-xl rounded-lg p-8 shadow-lg" style="background-color: #f5edcc;">
        <a href="{{ route('promoHome') }}" class="inline-block mb-6">
            <button type="button" class="bg-gray-200 hover:bg-[#E2BB4D] text-black font-semibold px-4 py-2 rounded border border-[#E2BB4D] transition">
                &larr; Kembali
            </button>
        </a>
        <h2 class="text-2xl font-bold mb-8 text-black text-center uppercase tracking-wider">Tambah Promo</h2>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-400 text-center rounded"> {{ session('success') }} </div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-400 text-center rounded">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ url('/promo/store') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-black">Deskripsi</label>
                <input type="text" name="description" placeholder="Deskripsi" required maxlength="100"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-black">Nilai Promo</label>
                <input type="number" name="promo_value" placeholder="Nilai Promo" required
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-black">Tipe Promo</label>
                <select name="value_type" required
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
                    <option value="fixed">Potongan Langsung</option>
                    <option value="percentage">Presentase</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-black">Minimal Order</label>
                <input type="number" name="minimum_order" placeholder="Minimal Order" required
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-black">Batas Pemakaian</label>
                <input type="number" name="usage_limit" placeholder="Batas Pemakaian" required
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
            </div>
            <div class="mb-6">
                <label class="block mb-1 font-semibold text-black">Status</label>
                <select name="status"
                    class="w-full border border-[#E2BB4D] bg-white px-3 py-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-[#E2BB4D]">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#E2BB4D] text-black font-bold px-8 py-2 rounded border border-[#E2BB4D] hover:bg-[#d1a53b] transition uppercase shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection