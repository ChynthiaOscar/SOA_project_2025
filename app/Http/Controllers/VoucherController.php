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
}