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

        Member::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function showLogin() {
        return view('pages.member.auth.login');
    }

    public function login(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('member')->attempt($credentials)) {
        $member = Auth::guard('member')->user();

        // Cek ulang tahun
        $today = now();
        if (
            $today->format('m-d') === $member->tanggal_lahir->format('m-d') &&
            $member->status == 0
        ) {
            $member->update(['status' => 1]);
        }

        return redirect()->route('profile');
    }

    return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function profile() {
    $member = Auth::guard('member')->user();
    return view('pages.member.profile', compact('member'));
    }


    public function logout() {
        Auth::guard('member')->logout();
        return redirect()->route('login');
    }

    public function showForgotPassword()
{
    return view('pages.member.auth.forgot_password');
}

public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email|exists:members,email']);

    $token = Str::random(60);
    DB::table('member_password_resets')->updateOrInsert(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => Carbon::now()]
    );

    $member = Member::where('email', $request->email)->first();
    $member->notify(new MemberResetPasswordNotification($token));

    return back()->with('status', 'Password reset link sent to your email.');
}

public function showResetPassword($token)
{
    return view('pages.member.auth.reset_password', ['token' => $token]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email|exists:members,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $reset = DB::table('member_password_resets')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
        return back()->withErrors(['email' => 'This password reset token is invalid or expired.']);
    }

    $member = Member::where('email', $request->email)->first();
    $member->update(['password' => Hash::make($request->password)]);

    DB::table('member_password_resets')->where('email', $request->email)->delete();

    return redirect()->route('login')->with('success', 'Password has been reset. You can now login.');
}
}

