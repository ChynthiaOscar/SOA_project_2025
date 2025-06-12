<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // pastikan model Member sudah ada
use Illuminate\Support\Facades\Auth;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

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

    // Kirim data update ke Nameko via RabbitMQ
    $data = [
        'member_id' => $member->id,
        'email' => $member->email,
        'no_hp' => $member->no_hp,
        'action' => 'profile_update'
    ];

    $connection = new AMQPStreamConnection(
        env('RABBITMQ_HOST', '127.0.0.1'),
        env('RABBITMQ_PORT', 5672),
        env('RABBITMQ_USER', 'guest'),
        env('RABBITMQ_PASSWORD', 'guest')
    );
    $channel = $connection->channel();
    $channel->queue_declare('profile_update', false, true, false, false);

    $msg = new AMQPMessage(json_encode($data));
    $channel->basic_publish($msg, '', 'profile_update');

    $channel->close();
    $connection->close();

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
