<?php
namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function create()
    {
        return view('pages.voucher-promo.voucher.createVoucher');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|unique:vouchers,promo_code|max:50',
            'description' => 'required|max:100',
            'promo_value' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        Voucher::create($request->all());
        return redirect('/promo')->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('pages.voucher-promo.voucher.editVoucher', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'promo_code' => 'required|max:50|unique:vouchers,promo_code,' . $voucher->id,
            'description' => 'required|max:100',
            'promo_value' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $voucher->update($request->all());
        return redirect('/promo')->with('success', 'Voucher berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();
        return redirect('/promo')->with('success', 'Voucher berhasil dihapus!');
    }
}