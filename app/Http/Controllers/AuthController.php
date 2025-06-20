<?php


namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Notifications\MemberResetPasswordNotification;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AuthController extends Controller
{
    public function showRegister() {
        return view('pages.member.auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $registerData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'password' => $request->password,
        ];

        $response = \Http::post('http://50.19.17.50:8002/register', $registerData);
        $result = $response->json();
        if (!$result['success']) {
            return back()->withErrors(['email' => $result['message']])->withInput();
        }
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function showLogin() {
        return view('pages.member.auth.login');
    }

    public function login(Request $request)
    {
        \Log::info('Login attempt:', $request->only('email', 'password'));
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = \Http::post('http://50.19.17.50:8002/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->ok() && $response->json('success')) {
            $data = $response->json();
            // Ambil data profile member dari API
            $profileResponse = \Http::get('http://50.19.17.50:8002/profile', [
                'member_id' => $data['member_id']
            ]);
            if ($profileResponse->ok() && $profileResponse->json('success')) {
                $profile = $profileResponse->json('member');
                // Tambahkan token dan expired ke profile
                $profile['token'] = $data['token'] ?? null;
                $profile['token_expires_at'] = $data['token_expires_at'] ?? null;
                \Session::put('member', $profile);
                // Debugging: pastikan session sudah terisi
                \Log::info('Session member after login:', [session('member')]);
                return redirect()->route('profile');
            } else {
                return back()->withErrors([
                    'login' => 'Gagal mengambil data profile.',
                ])->withInput();
            }
        } else {
            return back()->withErrors([
                'login' => $response->json('message') ?? 'Login failed.',
            ])->withInput();
        }
    }

    public function profile() {
        $member = \Session::get('member');
        if (!$member) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi Anda telah berakhir, silakan login kembali.']);
        }
        // Ambil data profile terbaru dari API jika ingin selalu up-to-date
        $response = \Http::get('http://50.19.17.50:8002/profile', [
            'member_id' => $member['id']
        ]);
        $data = $response->json();
        if ($response->ok() && $data['success']) {
            $profile = $data['member'];
            // Tambahkan token dan expired ke profile
            $profile['token'] = $member['token'] ?? null;
            $profile['token_expires_at'] = $member['token_expires_at'] ?? null;
            \Session::put('member', $profile);
        }
        return view('pages.member.profile', compact('member'));
    }

    public function logout() {
        $member = \Session::get('member');
        if ($member && isset($member['token'])) {
            \Http::post('http://50.19.17.50:8002/logout', [
                'token' => $member['token']
            ]);
        }
        \Session::forget('member');
        return redirect()->route('login');
    }
}

