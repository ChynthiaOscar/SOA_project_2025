<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryCategory;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::with('category')->get();
        return view('pages.service-inventory.index', compact('inventoryItems'));
    }

    public function create()
    {
        $categories = InventoryCategory::all();
        return view('pages.service-inventory.inventory.create', compact('categories'));
    }

    public function categories()
{
    $categories = InventoryCategory::with('items')->get(); // Pastikan relasi 'items' ada di model InventoryCategory
    return view('pages.service-inventory.category', compact('categories'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventoryItem_name' => 'required',
            'inventoryItem_description' => 'required',
            'inventoryItem_currentQuantity' => 'required|numeric',
            'inventoryItem_unitOfMeasure' => 'required',
            'inventoryItem_reorderPoint' => 'required|numeric',
            'inventoryItem_initialStockLevel' => 'required|numeric',
            'inventoryItem_lastUpdated' => 'required|date',
            'inventoryCategory_inventoryCategory_id' => 'required|exists:inventory_categories,inventoryCategory_id',
        ]);
        $lastId = InventoryItem::max('inventoryItem_id') ?? 0;
        $validated['inventoryItem_id'] = $lastId + 1;
        InventoryItem::create($validated);
        return redirect()->route('inventory.index')->with('success', 'Item added successfully!');
    }

    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);
        $categories = InventoryCategory::all();
        return view('pages.service-inventory.inventory.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'inventoryItem_name' => 'required',
            'inventoryItem_description' => 'required',
            'inventoryItem_currentQuantity' => 'required|numeric',
            'inventoryItem_unitOfMeasure' => 'required',
            'inventoryItem_reorderPoint' => 'required|numeric',
            'inventoryItem_initialStockLevel' => 'required|numeric',
            'inventoryItem_lastUpdated' => 'required|date',
            'inventoryCategory_inventoryCategory_id' => 'required|exists:inventory_categories,inventoryCategory_id',
        ]);
        $item = InventoryItem::findOrFail($id);
        $item->update($validated);
        // Redirect ke index agar langsung lihat data
        return redirect()->route('inventory.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $item->delete();
        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully!');
    }
}
