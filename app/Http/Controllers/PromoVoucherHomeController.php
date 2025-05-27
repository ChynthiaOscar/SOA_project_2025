<?php
namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Voucher;
use Illuminate\Http\Request;

class PromoVoucherHomeController extends Controller
{
    public function index(Request $request)
    {
        $searchPromo = $request->input('search_promo');
        $searchVoucher = $request->input('search_voucher');

        $promos = Promo::where('status', 1)
            ->when($searchPromo, function ($query, $searchPromo) {
                return $query->where('description', 'like', '%' . $searchPromo . '%');
            })
            ->paginate(5, ['*'], 'promo_page');

        $vouchers = Voucher::where('status', 1)
            ->when($searchVoucher, function ($query, $searchVoucher) {
                return $query->where('description', 'like', '%' . $searchVoucher . '%')
                            ->orWhere('promo_code', 'like', '%' . $searchVoucher . '%');
            })
            ->paginate(5, ['*'], 'voucher_page');

        return view('pages.voucher-promo.promoHome', compact('promos', 'vouchers', 'searchPromo', 'searchVoucher'));
    }
}
