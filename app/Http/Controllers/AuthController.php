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
            'email' => 'required|email|unique:members,email',
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

        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post(env('NAMEKO_GATEWAY_URL', 'http://localhost:8002') . '/register', [
                'json' => $registerData,
                'http_errors' => false
            ]);

            $result = json_decode($response->getBody(), true);
            
            if (!$result['success']) {
                return back()->withErrors(['email' => $result['message']])->withInput();
            }

            $member = \DB::table('members')->where('email', $request->email)->first();
            if ($member) {
                $hash = $member->password;
                if (strpos($hash, '$2b$') === 0) {
                    $hash = '$2y$' . substr($hash, 4);
                }
                \App\Models\Member::updateOrCreate(
                    ['email' => $member->email],
                    [
                        'nama' => $member->nama,
                        'tanggal_lahir' => $member->tanggal_lahir,
                        'no_hp' => $member->no_hp,
                        'password' => $hash,
                    ]
                );
            }

            return redirect()->route('login')->with('success', 'Registration successful. Please login.');
        } catch (\Exception $e) {
            \Log::error('Failed to register user in Nameko: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Registration failed, please try again.'])->withInput();
        }
    }

    public function showLogin() {
        return view('pages.member.auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('member')->attempt($credentials)) {
            $member = Auth::guard('member')->user();
            $token = (string) \Illuminate\Support\Str::uuid();
            $expiresAt = now()->addMinutes(5);
            $member->update([
                'token' => $token,
                'token_expires_at' => $expiresAt,
            ]);
            $data = [
                'member_id' => $member->id,
                'token' => $token,
                'token_expires_at' => $expiresAt->toDateTimeString(),
                'email' => $member->email,
            ];
            try {
                $connection = new AMQPStreamConnection(
                    env('RABBITMQ_HOST', '127.0.0.1'),
                    env('RABBITMQ_PORT', 5672),
                    env('RABBITMQ_USER', 'guest'),
                    env('RABBITMQ_PASSWORD', 'guest')
                );
                $channel = $connection->channel();
                $channel->queue_declare(env('RABBITMQ_QUEUE', 'auth_login'), false, true, false, false);
                $msg = new AMQPMessage(json_encode($data));
                $channel->basic_publish($msg, '', env('RABBITMQ_QUEUE', 'auth_login'));
                $channel->close();
                $connection->close();
            } catch (\Exception $e) {
                \Log::error('Failed to sync token with Nameko: ' . $e->getMessage());
            }
            return redirect()->route('profile');
        }
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function profile() {
        $member = Auth::guard('member')->user();
        if ($member && $member->token_expires_at && now()->greaterThan($member->token_expires_at)) {
            $member->update(['token' => null, 'token_expires_at' => null]);
            Auth::guard('member')->logout();
            return redirect()->route('login')->withErrors(['email' => 'Sesi Anda telah berakhir, silakan login kembali.']);
        }
        return view('pages.member.profile', compact('member'));
    }

    public function logout() {
        $member = Auth::guard('member')->user();
        if ($member && $member->token) {
            try {
                $client = new \GuzzleHttp\Client();
                $client->post(env('NAMEKO_GATEWAY_URL', 'http://localhost:8002') . '/logout', [
                    'json' => ['token' => $member->token],
                    'http_errors' => false
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to logout from Nameko: ' . $e->getMessage());
            }
            $member->update(['token' => null, 'token_expires_at' => null]);
        }
        Auth::guard('member')->logout();
        return redirect()->route('login');
    }
}

