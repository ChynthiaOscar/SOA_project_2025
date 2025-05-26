<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // pastikan model Member sudah ada
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $member = Auth::guard('member')->user(); // pastikan user sudah login
        return view('pages.member.edit', compact('member'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'no_hp' => 'required|string|max:15',
        ]);

        $member = Auth::guard('member')->user();
        $member->update([
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
