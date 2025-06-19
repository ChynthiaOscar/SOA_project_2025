<?php

namespace App\Http\Controllers;

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
        //
    }
}
