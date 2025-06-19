<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InventoryCategoryController extends Controller
{
    protected $gatewayUrl;

    public function __construct()
    {
        $this->gatewayUrl = env('GATEWAY_URL', 'http://localhost:8000');
    }
    
    public function index()
    {
        $categories = Http::get($this->gatewayUrl . '/categories')->json();
        return view('pages.service-inventory.category', compact('categories'));
    }

    public function create()
    {
        return view('pages.service-inventory.category.create');
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->input('inventoryCategory_name'),
            'description' => $request->input('inventoryCategory_description'),        ];
        Http::post($this->gatewayUrl . '/categories', $data);
        return redirect()->route('service-inventory.category')->with('success', 'Category added successfully!');
    }

    public function edit($id)
    {
        $category = Http::get("{$this->gatewayUrl}/categories/{$id}")->json();
        return view('pages.service-inventory.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name' => $request->input('inventoryCategory_name'),            'description' => $request->input('inventoryCategory_description'),
        ];
        Http::put("{$this->gatewayUrl}/categories/{$id}", $data);
        return redirect()->route('service-inventory.category')->with('success', 'Category updated successfully!');
    }    public function destroy($id)
    {
        Http::delete("{$this->gatewayUrl}/categories/{$id}");
        return redirect()->route('service-inventory.category')->with('success', 'Category deleted successfully!');
    }
}