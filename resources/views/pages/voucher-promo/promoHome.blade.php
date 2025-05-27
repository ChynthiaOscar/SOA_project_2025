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
    <div class="flex flex-wrap gap-4 mt-8 mb-10">
        <a href="{{ url('/promo/create') }}">
            <button class="bg-[#E2BB4D] text-black font-semibold px-6 py-3 border border-[#C9A441] shadow hover:bg-[#c29d34] transition duration-200 uppercase">+ Tambah Promo</button>
        </a>
        <a href="{{ url('/voucher/create') }}">
            <button class="bg-[#E2BB4D] text-black font-semibold px-6 py-3 border border-[#C9A441] shadow hover:bg-[#c29d34] transition duration-200 uppercase">+ Tambah Voucher</button>
        </a>
    </div>

    <!-- PROMO TABLE -->
    <div class="mb-12">
        <h3 class="text-xl font-bold mb-3 text-black uppercase">Daftar Promo Aktif</h3>
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
                            <td class="px-4 py-3 border border-black">{{ $promo->description }}</td>
                            <td class="px-4 py-3 border border-black">
                                @if($promo->value_type == 'percentage')
                                    {{ $promo->promo_value }}%
                                @else
                                    Rp {{ number_format($promo->promo_value, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-black capitalize">
                                {{ $promo->value_type == 'percentage' ? 'Presentase' : 'Potongan' }}
                            </td>
                            <td class="px-4 py-3 border border-black">Rp {{ number_format($promo->minimum_order, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 border border-black">{{ $promo->usage_limit }}</td>
                            <td class="px-4 py-3 border border-black">
                                {{ $promo->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                            </td>
                            <td class="px-4 py-3 border border-black text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ url('/promos/'.$promo->id.'/edit') }}" title="Edit" class="text-[#E2BB4D] hover:text-black transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6a2 2 0 002-2v-6a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                    <form action="{{ url('/promos/'.$promo->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promo ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete" class="text-red-600 hover:text-black transition duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-6 text-[#E2BB4D] font-medium">Tidak ada promo aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- VOUCHER TABLE -->
    <div>
        <h3 class="text-xl font-bold mb-3 text-black uppercase">Daftar Voucher Aktif</h3>
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
                            <td class="px-4 py-3 border border-black">{{ $voucher->promo_code }}</td>
                            <td class="px-4 py-3 border border-black">{{ $voucher->description }}</td>
                            <td class="px-4 py-3 border border-black">Rp {{ number_format($voucher->promo_value, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 border border-black">
                                {{ $promo->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                            </td>
                            <td class="px-4 py-3 border border-black text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ url('/vouchers/'.$voucher->id.'/edit') }}" title="Edit" class="text-[#E2BB4D] hover:text-black transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6a2 2 0 002-2v-6a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                    <form action="{{ url('/vouchers/'.$voucher->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete" class="text-red-600 hover:text-black transition duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-4 py-6 text-[#E2BB4D] font-medium">Tidak ada voucher aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection