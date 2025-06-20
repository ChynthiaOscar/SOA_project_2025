<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function chefTasks(Request $request)
    {
        // $token = $request->bearerToken();
        $token = session('user.accessToken');

        $employee = Http::withToken($token)->get('http://50.19.17.50:8002/employee/me')->json()['data'];

        $tasks = Http::get('http://50.19.17.50:8002/tasks/chef/' . $employee['name'])->json();

        return view('pages.service-kitchen.show', [
            'chef' => $employee,
            'tasks' => $tasks
        ]);
    }

    public function updateStatus(Request $request)
    {
        $payload = ['status' => 'done'];

        Http::put('http://50.19.17.50:8002/tasks/' . $request->task_id . '/edit', $payload);
        return redirect()->back();
    }
}
