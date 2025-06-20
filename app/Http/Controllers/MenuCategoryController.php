<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MenuCategoryController extends Controller
{
    const API_BASE_URL = 'http://50.19.17.50:8002';
    private $TOKEN = 'member123';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $response = Http::withHeader('Authorization', $this->TOKEN)->get(self::API_BASE_URL . '/menu-categories');
            $menuResponse = Http::withHeader('Authorization', $this->TOKEN)->get(self::API_BASE_URL . '/menus');
            if ($response->successful() && $menuResponse->successful()) {
                $categories = $response->json();
                $menus = $menuResponse->json();
                return view('pages.service-menu.admin_pages.menu-category', ['categories' => $categories, 'menus' => $menus]);
            } else {
                return back()->withErrors(['error' => 'Failed to retrieve categories']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $response = Http::withHeader('Authorization', $this->TOKEN)->post(self::API_BASE_URL . '/menu-categories', [
                'name' => $validated['name'],
            ]);
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to create category'], $response->status());
            } else {
                return redirect()->back()->with('success', 'Menu and recipes created successfully');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Server error'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $response = Http::withHeader('Authorization', $this->TOKEN)->put(self::API_BASE_URL . '/menu-categories', [
                'id' => $id,
                'name' => $validated['name'],
            ]);
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to update category'], $response->status());
            } else {
                return redirect()->back()->with('success', 'Menu and recipes updated successfully');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Server error'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $response = Http::withHeader('Authorization', $this->TOKEN)->delete("http://50.19.17.50:8002/menu-categories/{$id}");

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Category deleted successfully.');
            } else {
                return response()->json(['error' => 'Failed to delete category'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category'], 500);
        }
    }
}
