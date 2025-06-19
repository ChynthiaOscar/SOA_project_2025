<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MenuCategoryController extends Controller
{
    const API_BASE_URL = 'http://50.19.17.50:8002';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categoryResponse = Http::get(self::API_BASE_URL . '/menu-categories');
            $menuResponse = Http::get(self::API_BASE_URL . '/menus');

            if ($categoryResponse->successful() && $menuResponse->successful()) {
                $categories = $categoryResponse->json();
                $menus = collect($menuResponse->json())->groupBy('category_id');

                return view('pages.service-menu.customer_pages.order-menu', compact('categories', 'menus'));
            } else {
                return redirect()->back()->withErrors(['error' => 'Failed to fetch data']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function admin_index()
    {
        try {
            $response = Http::get(self::API_BASE_URL . '/menu-categories');
            $menuResponse = Http::get(self::API_BASE_URL . '/menus');
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
        try {
            $response = Http::get(self::API_BASE_URL . '/some-needed-data');
            if ($response->successful()) {
                $data = $response->json();
                return view('pages.service-menu.admin_pages.menu-category', compact('data'));
            } else {
                return back()->withErrors(['error' => 'Failed to retrieve categories']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Server error']);
        }
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
            $response = Http::post(self::API_BASE_URL . '/menu-categories', $validated);
            return $response->successful()
                ? redirect()->back()->with('success', 'Category created successfully.')
                : back()->withErrors(['error' => 'Failed to create category'])->withInput();
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
            $response = Http::put(self::API_BASE_URL . "/menu-categories/{$id}", $validated);
            return $response->successful()
                ? redirect()->back()->with('success', 'Category updated successfully.')
                : back()->withErrors(['error' => 'Failed to update category'])->withInput();
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
            $response = Http::delete(self::API_BASE_URL . "/menu-categories/{$id}");
            return $response->successful()
                ? redirect()->back()->with('success', 'Category deleted successfully.')
                : back()->withErrors(['error' => 'Failed to delete category']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Server error']);
        }
    }
}
