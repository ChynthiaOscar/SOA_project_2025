<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InventoryItemController extends Controller
{
    protected $gatewayUrl;

    public function __construct()
    {
        $this->gatewayUrl = env('GATEWAY_URL', 'http://localhost:8000');
    }

    public function index()
    {
        $response = Http::get($this->gatewayUrl . '/items');
        $inventoryItems = $response->json();
        return view('pages.service-inventory.index', compact('inventoryItems'));
    }

    public function create()
    {
        $categories = Http::get($this->gatewayUrl . '/categories')->json();
        return view('pages.service-inventory.inventory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->input('inventoryItem_name'),
            'description' => $request->input('inventoryItem_description'),
            'category_id' => $request->input('inventoryCategory_inventoryCategory_id'),
            'quantity' => $request->input('inventoryItem_currentQuantity'),
            'unit' => $request->input('inventoryItem_unitOfMeasure'),
            'reorder_point' => $request->input('inventoryItem_reorderPoint'),
            'initial_stock' => $request->input('inventoryItem_initialStockLevel'),
            'last_updated' => $request->input('inventoryItem_lastUpdated'),
        ];
        Http::post($this->gatewayUrl . '/items', $data);
        return redirect()->route('inventory.index')->with('success', 'Item added successfully!');
    }

    public function edit($id)
    {
        $item = Http::get("{$this->gatewayUrl}/items/{$id}")->json();
        $categories = Http::get($this->gatewayUrl . '/categories')->json();
        return view('pages.service-inventory.inventory.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name' => $request->input('inventoryItem_name'),
            'description' => $request->input('inventoryItem_description'),
            'category_id' => $request->input('inventoryCategory_inventoryCategory_id'),
            'quantity' => $request->input('inventoryItem_currentQuantity'),
            'unit' => $request->input('inventoryItem_unitOfMeasure'),
            'reorder_point' => $request->input('inventoryItem_reorderPoint'),
            'initial_stock' => $request->input('inventoryItem_initialStockLevel'),
            'last_updated' => $request->input('inventoryItem_lastUpdated'),
        ];
        Http::put("{$this->gatewayUrl}/items/{$id}", $data);
        return redirect()->route('inventory.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        Http::delete("{$this->gatewayUrl}/items/{$id}");
        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully!');
    }

    public function apiIndex()
    {
        $response = Http::get($this->gatewayUrl . '/items');
        return $response->json();
    }
}