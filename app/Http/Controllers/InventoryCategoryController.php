<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use Illuminate\Http\Request;

class InventoryCategoryController extends Controller
{
    public function index()
    {
        $categories = InventoryCategory::all();
        $inventoryItems = collect(); // Use a collection to avoid filter() error
        return view('pages.service-inventory.index', compact('categories', 'inventoryItems'));
    }

    public function create()
    {
        return view('pages.service-inventory.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventoryCategory_name' => 'required',
            'inventoryCategory_description' => 'required',
        ]);
        $lastId = InventoryCategory::max('inventoryCategory_id') ?? 0;
        $validated['inventoryCategory_id'] = $lastId + 1;
        InventoryCategory::create($validated);
        return redirect()->route('service-inventory.category')->with('success', 'Category added successfully!');
    }

    public function edit($id)
    {
        $category = \App\Models\InventoryCategory::where('inventoryCategory_id', $id)->firstOrFail();
        return view('pages.service-inventory.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'inventoryCategory_name' => 'required',
            'inventoryCategory_description' => 'required',
        ]);
        $category = InventoryCategory::findOrFail($id);
        $category->update($validated);
        return redirect()->route('service-inventory.category')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = InventoryCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('service-inventory.category')->with('success', 'Category deleted successfully!');
    }

    public function show($id)
    {
        $category = InventoryCategory::with('items')->findOrFail($id);
        return view('pages.service-inventory.category.show', compact('category'));
    }
}
