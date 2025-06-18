{{-- filepath: resources/views/pages/voucher-promo/promoHome.blade.php --}}
@extends('layouts.voucher')

@section('title', 'Promo & Voucher')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    <!-- HEADER -->
    <div class="bg-[#E2BB4D] px-8 py-6 border-b-[6px] border-[#C9A441] shadow-md">
        <h2 class="text-3xl font-extrabold tracking-wider text-black uppercase">PROMO & VOUCHER</h2>
        <p class="text-lg font-medium text-black mt-1">Kelola promo dan voucher yang sedang aktif</p>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="flex flex-wrap gap-4 mt-8 mb-6">
        <a href="{{ url('/promo/create') }}">
            <button class="bg-[#E2BB4D] text-black font-semibold px-6 py-3 border border-[#C9A441] shadow hover:bg-[#c29d34] transition duration-200 uppercase">+ Tambah Promo</button>
        </a>
        <a href="{{ url('/voucher/create') }}">
            <button class="bg-[#E2BB4D] text-black font-semibold px-6 py-3 border border-[#C9A441] shadow hover:bg-[#c29d34] transition duration-200 uppercase">+ Tambah Voucher</button>
        </a>
    </div>

    <!-- SEARCH PROMO -->
    <form method="GET" class="mb-6">
        <input type="text" name="search_promo" value="{{ request('search_promo') }}" placeholder="Cari Promo..." class="border px-4 py-2 rounded w-full md:w-1/2 mb-2">
        <button type="submit" class="ml-2 bg-black text-[#E2BB4D] px-4 py-2 rounded">Cari Promo</button>
    </form>

    <!-- PROMO TABLE -->
    <div class="mb-12 border-b-4 border-dashed border-gray-400 pb-12">
        <h3 class="text-xl font-bold mb-3 text-black uppercase">Daftar Promo</h3>
        <div class="overflow-x-auto shadow border border-black">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-black text-[#E2BB4D] uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border border-black font-bold">Deskripsi</th>
                        <th class="px-4 py-3 border border-black font-bold">Nilai</th>
                        <th class="px-4 py-3 border border-black font-bold">Tipe</th>
                        <th class="px-4 py-3 border border-black font-bold">Min. Order</th>
                        <th class="px-4 py-3 border border-black font-bold">Limit</th>
                        <th class="px-4 py-3 border border-black font-bold">Status</th>
                        <th class="px-4 py-3 border border-black font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-black">
                    @forelse($promos as $promo)
                        <tr class="border-b border-black hover:bg-[#F9F1DC] transition duration-150">
                            <td class="px-4 py-3 border border-black">{{ $promo['description'] }}</td>
                            <td class="px-4 py-3 border border-black">
                                @if($promo['value_type'] == 'percentage')
                                    {{ $promo['promo_value'] }}%
                                @else
                                    Rp {{ number_format($promo['promo_value'], 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-black capitalize">
                                {{ $promo['value_type'] == 'percentage' ? 'Presentase' : 'Potongan' }}
                            </td>
                            <td class="px-4 py-3 border border-black">Rp {{ number_format($promo['minimum_order'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 border border-black">{{ $promo['usage_limit'] }}</td>
                            <td class="px-4 py-3 border border-black">
                                <span class="font-semibold {{ $promo['status'] == 1 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $promo['status'] == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border border-black text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ url('/promos/'.$promo['id'].'/edit') }}" title="Edit" class="text-[#E2BB4D] hover:text-black transition duration-150">
                                        ✏️
                                    </a>
                                    <form action="{{ url('/promos/'.$promo['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promo ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete" class="text-red-600 hover:text-black transition duration-150">
                                            ❌
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center px-4 py-6 text-[#E2BB4D] font-medium">Tidak ada promo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $promos->appends(['search_promo' => request('search_promo')])->links() }}
        </div>
    </div>

    <!-- SEARCH VOUCHER -->
    <form method="GET" class="mb-6">
        <input type="text" name="search_voucher" value="{{ request('search_voucher') }}" placeholder="Cari Voucher..." class="border px-4 py-2 rounded w-full md:w-1/2 mb-2">
        <button type="submit" class="ml-2 bg-black text-[#E2BB4D] px-4 py-2 rounded">Cari Voucher</button>
    </form>

    <!-- VOUCHER TABLE -->
    <div>
        <h3 class="text-xl font-bold mb-3 text-black uppercase">Daftar Voucher</h3>
        <div class="overflow-x-auto shadow border border-black">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-black text-[#E2BB4D] uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border border-black font-bold">Kode Voucher</th>
                        <th class="px-4 py-3 border border-black font-bold">Deskripsi</th>
                        <th class="px-4 py-3 border border-black font-bold">Nilai</th>
                        <th class="px-4 py-3 border border-black font-bold">Status</th>
                        <th class="px-4 py-3 border border-black font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-black">
                    @forelse($vouchers as $voucher)
                        <tr class="border-b border-black hover:bg-[#F9F1DC] transition duration-150">
                            <td class="px-4 py-3 border border-black">{{ $voucher['promo_code'] }}</td>
                            <td class="px-4 py-3 border border-black">{{ $voucher['description'] }}</td>
                            <td class="px-4 py-3 border border-black">Rp {{ number_format($voucher['promo_value'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 border border-black">
                                <span class="font-semibold {{ $voucher['status'] == 1 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $voucher['status'] == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border border-black text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ url('/vouchers/'.$voucher['id'].'/edit') }}" title="Edit" class="text-[#E2BB4D] hover:text-black transition duration-150">
                                        ✏️
                                    </a>
                                    <form action="{{ url('/vouchers/'.$voucher['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete" class="text-red-600 hover:text-black transition duration-150">
                                            ❌
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-6 text-[#E2BB4D] font-medium">Tidak ada voucher.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $vouchers->appends(['search_voucher' => request('search_voucher')])->links() }}
        </div>
    </div>
</div>
@endsection