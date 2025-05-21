@extends('layouts.app')

@section('title', 'Promo & Voucher')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">Promo & Voucher Aktif</h2>
    <div class="mb-6 flex gap-4">
        <a href="{{ url('/promo/create') }}">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Promo</button>
        </a>
        <a href="{{ url('/voucher/create') }}">
            <button class="bg-green-600 text-white px-4 py-2 rounded">Tambah Voucher</button>
        </a>
    </div>

    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-2">Daftar Promo Aktif</h3>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Deskripsi</th>
                    <th class="border px-4 py-2">Nilai</th>
                    <th class="border px-4 py-2">Tipe</th>
                    <th class="border px-4 py-2">Min. Order</th>
                    <th class="border px-4 py-2">Limit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                <tr>
                    <td class="border px-4 py-2">{{ $promo->description }}</td>
                    <td class="border px-4 py-2">{{ $promo->promo_value }}</td>
                    <td class="border px-4 py-2">{{ $promo->value_type }}</td>
                    <td class="border px-4 py-2">{{ $promo->minimum_order }}</td>
                    <td class="border px-4 py-2">{{ $promo->usage_limit }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="border px-4 py-2 text-center">Tidak ada promo aktif.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        <h3 class="text-xl font-semibold mb-2">Daftar Voucher Aktif</h3>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Kode Voucher</th>
                    <th class="border px-4 py-2">Deskripsi</th>
                    <th class="border px-4 py-2">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $voucher)
                <tr>
                    <td class="border px-4 py-2">{{ $voucher->promo_code }}</td>
                    <td class="border px-4 py-2">{{ $voucher->description }}</td>
                    <td class="border px-4 py-2">{{ $voucher->promo_value }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="border px-4 py-2 text-center">Tidak ada voucher aktif.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection