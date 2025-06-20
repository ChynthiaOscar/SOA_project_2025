<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class PromoVoucherHomeController extends Controller
{
    private $gateway = 'http://50.19.17.50:8002';
    
    public function index(Request $request)
    {
        $searchPromo = $request->input('search_promo');
        $searchVoucher = $request->input('search_voucher');

        // Ambil semua data dari gateway
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get($this->gateway . '/promo/all');
        
        $result = $response->json();
        $promos = isset($result['promos']) ? $result['promos'] : [];
        $vouchers = isset($result['vouchers']) ? $result['vouchers'] : [];

        // Filter pencarian promo
        if ($searchPromo) {
            $promos = array_values(array_filter($promos, function($promo) use ($searchPromo) {
                return stripos($promo['description'], $searchPromo) !== false;
            }));
        }

        // Filter pencarian voucher
        if ($searchVoucher) {
            $vouchers = array_values(array_filter($vouchers, function($voucher) use ($searchVoucher) {
                return stripos($voucher['description'], $searchVoucher) !== false
                    || stripos($voucher['promo_code'], $searchVoucher) !== false;
            }));
        }

        // Manual pagination untuk promo
        $promoPerPage = 5;
        $promoCurrentPage = LengthAwarePaginator::resolveCurrentPage('promo_page');
        $promoCurrentItems = array_slice($promos, ($promoCurrentPage - 1) * $promoPerPage, $promoPerPage);
        $promosPaginator = new LengthAwarePaginator(
            $promoCurrentItems,
            count($promos),
            $promoPerPage,
            $promoCurrentPage,
            ['pageName' => 'promo_page', 'path' => $request->url(), 'query' => $request->query()]
        );

        // Manual pagination untuk voucher
        $voucherPerPage = 5;
        $voucherCurrentPage = LengthAwarePaginator::resolveCurrentPage('voucher_page');
        $voucherCurrentItems = array_slice($vouchers, ($voucherCurrentPage - 1) * $voucherPerPage, $voucherPerPage);
        $vouchersPaginator = new LengthAwarePaginator(
            $voucherCurrentItems,
            count($vouchers),
            $voucherPerPage,
            $voucherCurrentPage,
            ['pageName' => 'voucher_page', 'path' => $request->url(), 'query' => $request->query()]
        );

        return view('pages.voucher-promo.promoHome', [
            'promos' => $promosPaginator,
            'vouchers' => $vouchersPaginator,
            'searchPromo' => $searchPromo,
            'searchVoucher' => $searchVoucher
        ]);
    }
}