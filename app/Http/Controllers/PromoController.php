<?php
namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function create()
    {
        return view('pages.voucher-promo.promo.createPromo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:100',
            'promo_value' => 'required|integer',
            'value_type' => 'required|in:fixed,percentage',
            'minimum_order' => 'required|integer',
            'usage_limit' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        Promo::create($request->all());
        return redirect('/promo')->with('success', 'Promo berhasil ditambahkan!');
    }
}