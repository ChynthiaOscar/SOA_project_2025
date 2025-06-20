<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use Storage;

class MenuRecipeController extends Controller
{
    private $TOKEN = 'member123';
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
            $image_path = 'images/service-menu/' . $original_name;

            // Cek apakah file sudah ada
            if (!Storage::disk('public')->exists($image_path)) {
                $image->storeAs('images/service-menu', $original_name, 'public');
            }
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

        $menu_response = Http::withHeader('Authorization', $this->TOKEN)->post('http://50.19.17.50:8002/menus', [
            'image' => $data['image'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'category_id' => $data['category_id']
        ]);

        foreach ($ingredients as $ingredient) {
            $recipe_response = Http::withHeader('Authorization', $this->TOKEN)->post('http://50.19.17.50:8002/menu-recipes', [
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
    public function edit(string $id, Request $request)
    {
        $menu_response = Http::withHeader('Authorization', $this->TOKEN)->get("http://50.19.17.50:8002/menus/{$id}");
        $recipe_response = Http::withHeader('Authorization', $this->TOKEN)->get("http://50.19.17.50:8002/menu-recipes");

        if (!$menu_response->successful()) {
            return response()->json(['error' => 'Failed to retrieve menu'], $menu_response->status());
        } elseif (!$recipe_response->successful()) {
            return response()->json(['error' => 'Failed to retrieve recipes'], $recipe_response->status());
        }

        $validated_data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
        ]);

        // Handle the uploaded image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $original_name = $image->getClientOriginalName();
            $image_path = 'images/service-menu/' . $original_name;

            // Cek apakah file sudah ada
            if (!Storage::disk('public')->exists($image_path)) {
                $old_image = $menu_response->json()['image'] ?? null;
                if ($old_image && Storage::disk('public')->exists('images/service-menu/' . $old_image)) {
                    Storage::disk('public')->delete('images/service-menu/' . $old_image);
                }
                $image->storeAs('images/service-menu', $original_name, 'public');
            }
            $validated_data['image'] = $original_name;
        } else {
            $validated_data['image'] = $menu_response->json()['image'];
        }

        return view('pages.service-menu.admin_pages.menu.edit-recipe', [
            'id' => $id,
            'image' => $validated_data['image'],
            'name' => $validated_data['name'],
            'description' => $validated_data['description'],
            'price' => $validated_data['price'],
            'category_id' => $validated_data['category_id'],
            'recipes' => $recipe_response->json(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $ingredients = json_decode($data['list_ingredient'], true);

        // Update the menu
        $menu_response = Http::withHeader('Authorization', $this->TOKEN)->put("http://50.19.17.50:8002/menus", [
            'id' => $id,
            'image' => $data['image'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'category_id' => $data['category_id']
        ]);

        // Update the recipes
        foreach ($ingredients as $ingredient) {
            $recipe_response = Http::withHeader('Authorization', $this->TOKEN)->put("http://50.19.17.50:8002/menu-recipes", [
                'id' => $ingredient['recipe_id'],
                'quantity' => $ingredient['amount'],
                'menu_id' => $id,
                'inventory_id' => $ingredient['id']
            ]);
        }

        if (!$menu_response->successful()) {
            return response()->json(['error' => 'Failed to update menu'], $menu_response->status());
        } elseif (!$recipe_response->successful()) {
            return response()->json(['error' => 'Failed to update recipes'], $recipe_response->status());
        } else {
            return redirect()->route('menu_index')->with('success', 'Menu and recipes updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
