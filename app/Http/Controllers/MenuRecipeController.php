<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class MenuRecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated_data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
        ]);

        // Handle the uploaded image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $original_name = $image->getClientOriginalName();
            $image->storeAs('images/service-menu', $original_name, 'public');
            $validated_data['image'] = $original_name;
        }

        return view('pages.service-menu.admin_pages.menu.add-recipe', [
            'image' => $validated_data['image'],
            'name' => $validated_data['name'],
            'description' => $validated_data['description'],
            'price' => $validated_data['price'],
            'category_id' => $validated_data['category_id'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $ingredients = json_decode($data['list_ingredient'], true);

        $menu_response = Http::post('http://3.228.0.178:8002/menus', [
            'image' => $data['image'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'category_id' => $data['category_id']
        ]);

        foreach ($ingredients as $ingredient) {
            $recipe_response = Http::post('http://3.228.0.178:8002/menu-recipes', [
                'quantity' => $ingredient['amount'],
                'menu_id' => $menu_response->json()['id'],
                'inventory_id' => $ingredient['id']
            ]);
        }

        if (!$menu_response->successful()) {
            return response()->json(['error' => 'Failed to create menus'], $menu_response->status());
        } elseif (!$recipe_response->successful()) {
            return response()->json(['error' => 'Failed to create recipes'], $recipe_response->status());
        } else {
            return redirect()->route('menu_index')->with('success', 'Menu and recipes created successfully');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
