<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ProfileController extends Controller
{
    public function edit()
    {
        $member = \Session::get('member');
        return view('pages.member.edit', compact('member'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'no_hp' => 'required|string|max:15',
        ]);
        $member = \Session::get('member');
        $data = [
            'member_id' => $member['id'],
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ];
        $response = \Http::put('http://50.19.17.50:8002/profile', $data);
        $result = $response->json();
        \Log::info('Profile update result:', $result);
        if (!$result['success']) {
            return back()->withErrors(['update' => $result['message'] ?? 'Gagal update profil.']);
        }
        // Ambil data profile terbaru dari API setelah update
        $profileResponse = \Http::get('http://50.19.17.50:8002/profile', [
            'member_id' => $member['id']
        ]);
        if ($profileResponse->ok() && $profileResponse->json('success')) {
            $profile = $profileResponse->json('member');
            $profile['token'] = $member['token'] ?? null;
            $profile['token_expires_at'] = $member['token_expires_at'] ?? null;
            \Session::put('member', $profile);
            \Log::info('Session after update:', [session('member')]);
        } else {
            // Jika gagal ambil profile, tetap update session manual
            $member['email'] = $request->email;
            $member['no_hp'] = $request->no_hp;
            \Session::put('member', $member);
        }
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $member = \Session::get('member');
        $url = 'http://50.19.17.50:8002/profile?member_id=' . $member['id'];
        $response = \Http::delete($url);
        $result = $response->json();
        if (!isset($result['success']) || !$result['success']) {
            return back()->withErrors(['delete' => $result['message'] ?? 'Gagal menghapus akun.']);
        }
        \Session::forget('member');
        return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus.');
    }
}
