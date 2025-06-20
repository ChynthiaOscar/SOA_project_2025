<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function user_index()
    {
        try {
            $menu_response = Http::get('http://50.19.17.50:8002/menus');
            $category_response = Http::get('http://50.19.17.50:8002/menu-categories');
            // TODO: Handle rating response
            // TODO: Handle availability response

            if (!$menu_response->successful()) {
                return response()->json(['error' => 'Failed to retrieve menus'], $menu_response->status());
            } elseif (!$category_response->successful()) {
                return response()->json(['error' => 'Failed to retrieve categories'], $category_response->status());
            } else {
                $menus = $menu_response->json();
                $categories = $category_response->json();
                return view('pages.service-menu.customer_pages.order-menu', [
                    'menus' => $menus,
                    'categories' => $categories
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve menus'], 500);
        }
    }

    public function admin_index()
    {
        try {
            $menu_response = Http::get('http://50.19.17.50:8002/menus');

            if ($menu_response->successful()) {
                $menus = $menu_response->json();
                return view('pages.service-menu.admin_pages.menu.index', [
                    'menus' => $menus
                ]);
            } else {
                return response()->json(['error' => 'Failed to retrieve menus'], $menu_response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve menus'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $category_response = Http::get('http://50.19.17.50:8002/menu-categories');

            if (!$category_response->successful()) {
                return response()->json(['error' => 'Failed to retrieve categories'], $category_response->status());
            } else {
                $categories = $category_response->json();
                return view('pages.service-menu.admin_pages.menu.create', [
                    'categories' => $categories
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve menus'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        try {
            $category_response = Http::get('http://50.19.17.50:8002/menu-categories');
            $menu_response = Http::get("http://50.19.17.50:8002/menus/{$id}");

            if (!$category_response->successful()) {
                return response()->json(['error' => 'Failed to retrieve categories'], $category_response->status());
            } elseif (!$menu_response->successful()) {
                return response()->json(['error' => 'Failed to retrieve menu'], $menu_response->status());
            } else {
                $categories = $category_response->json();
                $menu = $menu_response->json();
                return view('pages.service-menu.admin_pages.menu.edit', [
                    'categories' => $categories,
                    'menu' => $menu
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve menus'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('menu_id');
        try {
            $response = Http::delete("http://50.19.17.50:8002/menus/{$id}");

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Menu deleted successfully.');
            } else {
                return response()->json(['error' => 'Failed to delete menu'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete menu'], 500);
        }
    }
}
