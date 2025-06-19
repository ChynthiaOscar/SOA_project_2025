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
        $member = Auth::guard('member')->user();
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

        $data = [
            'member_id' => $member->id,
            'email' => $member->email,
            'no_hp' => $member->no_hp,
        ];

        try {
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
        } catch (\Exception $e) {
            \Log::error('Failed to sync profile update with Nameko: ' . $e->getMessage());
        }

        try {
            $client = new \GuzzleHttp\Client();
            $client->put(env('NAMEKO_GATEWAY_URL', 'http://localhost:8002') . '/profile', [
                'json' => [
                    'member_id' => $member->id,
                    'email' => $member->email,
                    'no_hp' => $member->no_hp,
                ],
                'http_errors' => false
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to update profile in Nameko via API: ' . $e->getMessage());
        }

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
