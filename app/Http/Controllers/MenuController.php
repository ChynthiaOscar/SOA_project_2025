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
            $menu_response = Http::get('http://3.228.0.178:8002/menus');
            $category_response = Http::get('http://3.228.0.178:8002/menu-categories');
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
            $menu_response = Http::get('http://3.228.0.178:8002/menus');

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
            $menu_response = Http::get('http://3.228.0.178:8002/menus');
            $category_response = Http::get('http://3.228.0.178:8002/menu-categories');

            if (!$menu_response->successful()) {
                return response()->json(['error' => 'Failed to retrieve menus'], $menu_response->status());
            } elseif (!$category_response->successful()) {
                return response()->json(['error' => 'Failed to retrieve categories'], $category_response->status());
            } else {
                $menus = $menu_response->json();
                $categories = $category_response->json();
                return view('pages.service-menu.admin_pages.menu.create', [
                    'menus' => $menus,
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $response = Http::delete("http://3.228.0.178:8002/menus/{$id}");

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
