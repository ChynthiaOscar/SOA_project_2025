<?php
namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Voucher;

class PromoVoucherHomeController extends Controller
{
    public function index()
    {
        $promos = Promo::where('status', 1)->get();
        $vouchers = Voucher::where('status', 1)->get();
        return view('pages.voucher-promo.promoHome', compact('promos', 'vouchers'));
    }
}