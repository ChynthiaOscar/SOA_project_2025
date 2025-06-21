<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function chefTasks(Request $request)
    {
        $token = session('user.accessToken');

        if (!$token) {
            abort(401, 'Unauthorized');
        }

        $userResponse = Http::withToken($token)->get('http://50.19.17.50:8002/employee/me');
        if (!$userResponse->ok()) {
            abort(403, 'Gagal mengambil data user');
        }

        $employee = $userResponse->json()['data'];
        if ($employee['role'] === 'Cashier') {
            return redirect()->route('kitchen.index');
        } elseif ($employee['role'] !== 'Chef') {
            abort(403, 'Akses ditolak');
        }

        $name = urlencode($employee['name']);
        $response = Http::withToken($token)->get("http://50.19.17.50:8002/tasks/chef/{$name}");

        if (!$response->ok()) {
            abort(500, 'Gagal mengambil data task');
        }

        $tasks = $response->json()['data'];

        return view('pages.service-kitchen.show', [
            'chef' => $employee,
            'tasks' => $tasks
        ]);
    }

    public function updateStatus(Request $request)
    {
        $taskId = $request->task_id;
        $menuName = $request->menu;
        $quantity = $request->quantity;

        Http::put("http://50.19.17.50:8002/tasks/{$taskId}/edit", ['status' => 'done']);

        $menusResponse = Http::get("http://50.19.17.50:8002/menus");
        if (!$menusResponse->ok()) {
            return redirect()->back()->with('error', 'Gagal mengambil daftar menu');
        }

        $menus = $menusResponse->json();
        $matchedMenu = collect($menus)->firstWhere('name', $menuName);

        if (!$matchedMenu) {
            return redirect()->back()->with('error', "Menu '$menuName' tidak ditemukan");
        }

        $menuId = $matchedMenu['id'];

        $recipesResponse = Http::get("http://50.19.17.50:8002/menu-recipes/{$menuId}");
        if (!$recipesResponse->ok()) {
            return redirect()->back()->with('error', 'Gagal mengambil resep menu');
        }

        $recipes = $recipesResponse->json();

        foreach ($recipes as $item) {
            $inventoryId = $item['inventory_id'];
            $neededQty = $item['quantity'] * $quantity;

            Http::put("http://50.19.17.50:8003/inventory/{$inventoryId}/reduce", [
                'quantity' => $neededQty
            ]);
        }

        return redirect()->back()->with('success', 'Status diperbarui & stok dikurangi');
    }
}
