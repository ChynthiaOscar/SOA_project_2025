@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-8 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Tambah Promo</h2>
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    <form method="POST" action="/promo/store" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-semibold">Deskripsi</label>
            <input type="text" name="description" placeholder="Deskripsi" required maxlength="100"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Nilai Promo</label>
            <input type="number" name="promo_value" placeholder="Nilai Promo" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Tipe Promo</label>
            <select name="value_type" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="fixed">Potongan Langsung</option>
                <option value="percentage">Presentase</option>
            </select>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Minimal Order</label>
            <input type="number" name="minimum_order" placeholder="Minimal Order" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Batas Pemakaian</label>
            <input type="number" name="usage_limit" placeholder="Batas Pemakaian" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Status</label>
            <select name="status"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>
        </div>
        <div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection