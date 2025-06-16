<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function chefTasks(Request $request)
    {
        $token = $request->bearerToken();

        // Ambil info chef yang login
        $employee = Http::withToken($token)->get('http://gateway-service/employee/me')->json()['data'];

        // Ambil task berdasarkan nama atau ID employee
        $tasks = Http::get('http://gateway-service/kitchen-tasks/' . $employee['name'])->json();

        return view('pages.service-kitchen.chef', [
            'chef' => $employee,
            'tasks' => $tasks
        ]);
    }

    public function updateStatus(Request $request)
    {
        $payload = [
            'kitchen_task_id' => $request->task_id,
            'status' => 'done'
        ];

        Http::post('http://gateway-service/kitchen-tasks/status', $payload);

        return redirect()->back();
    }
}
