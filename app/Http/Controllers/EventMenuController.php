<?php

namespace App\Http\Controllers;

use App\Utils\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventMenuController extends Controller
{
    use HttpResponse;

    private $url;

    public function __construct()
    {
        $this->url = env("API_URL");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $response = Http::get($this->url . '/event_menus?page=' . $page);
        $res = json_decode($response);
        $data['menus'] = $res->data->data ?? [];
        $data['pagination'] = $res->data ?? null;
        $data['title'] = "Manage Event Menus";
        return view('pages.service-event.admin.event_menus.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = "Create Event Menu";
        
        $response = Http::get($this->url . '/dish_categories?per_page=100');
        $res = json_decode($response);
        $categories = [];
        if ($response->successful() && isset($res->data)) {
            $categories = is_array($res->data) ? $res->data : ($res->data->data ?? []);
        }
        $data['categories'] = $categories;
        return view('pages.service-event.admin.event_menus.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }
        $response = Http::post($this->url . '/event_menus', $data);
        $res = json_decode($response);
        return $this->success("Event menu created successfully", $res->data ?? null);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['title'] = "Edit Event Menu";
        $response = Http::get($this->url . "/event_menus/" . $id);
        $res = json_decode($response);
        $data['event_menu'] = $res->data ?? null;
        // Fetch dish categories for the dropdown
        $categoriesResponse = Http::get($this->url . '/dish_categories?per_page=100');
        $categoriesRes = json_decode($categoriesResponse);
        $categories = [];
        if ($categoriesResponse->successful() && isset($categoriesRes->data)) {
            $categories = is_array($categoriesRes->data) ? $categoriesRes->data : ($categoriesRes->data->data ?? []);
        }
        $data['categories'] = $categories;
        return view('pages.service-event.admin.event_menus.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }
        $response = Http::put($this->url . '/event_menus/' . $id, $data);
        $res = json_decode($response);
        return $this->success("Event menu updated successfully", $res->data ?? null);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete($this->url . '/event_menus/' . $id);
        $res = json_decode($response);
        return $this->success("Event menu deleted successfully", $res->data ?? null);
    }
}
