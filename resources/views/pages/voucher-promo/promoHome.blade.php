{{-- filepath: resources/views/pages/voucher-promo/promoHome.blade.php --}}
@extends('layouts.voucher')

@section('title', 'Promo & Voucher')

@section('content')
<div class="flex min-h-screen bg-[#eeeacb]">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#7a0c0c] flex flex-col py-0 px-0 min-h-screen">
        <div class="flex flex-col items-start px-8 py-8">
            <div class="text-2xl font-extrabold text-[#FFD700] mb-2">LOGO</div>
            <div class="mb-10">
                <div class="text-white font-semibold">Jonathan Edward</div>
                <div class="text-xs text-[#FFD700]">c14220203@john.petra.ac.id</div>
            </div>
            <nav class="flex flex-col gap-2 w-full">
                <a href="{{ url('/promo') }}" class="flex items-center gap-2 px-4 py-2 rounded {{ request()->is('promo') ? 'bg-[#C9A441] text-black font-bold' : 'text-white hover:bg-[#C9A441] hover:text-black' }}">
                    <span>🏠</span> Home
                </a>
                <a href="{{ url('/promo/create') }}" class="flex items-center gap-2 px-4 py-2 rounded text-white hover:bg-[#C9A441] hover:text-black">
                    <span>➕</span> Tambah Promo
                </a>
                <a href="{{ url('/voucher/create') }}" class="flex items-center gap-2 px-4 py-2 rounded text-white hover:bg-[#C9A441] hover:text-black">
                    <span>➕</span> Tambah Voucher
                </a>
            </nav>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 px-0 py-0">
        <!-- HEADER -->
        <div class="bg-[#E2BB4D] px-12 py-8 border-b-[6px] border-[#C9A441] shadow-md rounded-none">
            <h2 class="text-3xl font-extrabold tracking-wider text-black uppercase mb-1">PROMO & VOUCHER</h2>
            <p class="text-lg font-medium text-black">Kelola promo dan voucher yang sedang aktif</p>
        </div>

        <!-- CONTENT -->
        <div class="px-12 py-8">
            <!-- SEARCH PROMO -->
            <form method="GET" class="mb-4 flex gap-2">
                <input type="text" name="search_promo" value="{{ request('search_promo') }}" placeholder="Cari Promo..." class="border px-4 py-2 rounded w-full max-w-lg">
                <button type="submit" class="bg-black text-[#E2BB4D] px-6 py-2 rounded font-semibold">Cari Promo</button>
            </form>

            <!-- PROMO TABLE -->
            <h3 class="text-xl font-bold mb-3 text-black uppercase">DAFTAR PROMO</h3>
            <div class="overflow-x-auto shadow border border-black rounded mb-8">
                <table class="min-w-full text-sm text-left bg-[#EEEACB]">
                    <thead class="bg-black text-[#E2BB4D] uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 border border-black font-bold">DESKRIPSI</th>
                            <th class="px-4 py-3 border border-black font-bold">NILAI</th>
                            <th class="px-4 py-3 border border-black font-bold">TIPE</th>
                            <th class="px-4 py-3 border border-black font-bold">MIN. ORDER</th>
                            <th class="px-4 py-3 border border-black font-bold">LIMIT</th>
                            <th class="px-4 py-3 border border-black font-bold">STATUS</th>
                            <th class="px-4 py-3 border border-black font-bold text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-black">
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
                                    <a href="{{ url('/promos/'.$promo['id'].'/edit') }}" title="Edit" class="text-[#E2BB4D] hover:text-black text-lg mr-2">
                                        ✏️
                                    </a>
                                    <form action="{{ url('/promos/'.$promo['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promo ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete" class="text-red-600 hover:text-black text-lg">
                                            ❌
                                        </button>
                                    </form>
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

            <div class="mb-8">
                {{ $promos->appends(['search_promo' => request('search_promo')])->links() }}
            </div>

            <hr class="border-dashed border-2 border-gray-400 mb-8">

            <!-- SEARCH VOUCHER -->
            <form method="GET" class="mb-4 flex gap-2">
                <input type="text" name="search_voucher" value="{{ request('search_voucher') }}" placeholder="Cari Voucher..." class="border px-4 py-2 rounded w-full max-w-lg">
                <button type="submit" class="bg-black text-[#E2BB4D] px-6 py-2 rounded font-semibold">Cari Voucher</button>
            </form>

            <!-- VOUCHER TABLE -->
            <h3 class="text-xl font-bold mb-3 text-black uppercase">DAFTAR VOUCHER</h3>
            <div class="overflow-x-auto shadow border border-black rounded">
                <table class="min-w-full text-sm text-left bg-[#EEEACB]">
                    <thead class="bg-black text-[#E2BB4D] uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 border border-black font-bold">KODE VOUCHER</th>
                            <th class="px-4 py-3 border border-black font-bold">DESKRIPSI</th>
                            <th class="px-4 py-3 border border-black font-bold">NILAI</th>
                            <th class="px-4 py-3 border border-black font-bold">STATUS</th>
                            <th class="px-4 py-3 border border-black font-bold text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-black">
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
                                    <a href="{{ url('/vouchers/'.$voucher['id'].'/edit') }}" title="Edit" class="text-[#E2BB4D] hover:text-black text-lg mr-2">
                                        ✏️
                                    </a>
                                    <form action="{{ url('/vouchers/'.$voucher['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete" class="text-red-600 hover:text-black text-lg">
                                            ❌
                                        </button>
                                    </form>
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
            <div class="mt-8">
                {{ $vouchers->appends(['search_voucher' => request('search_voucher')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection