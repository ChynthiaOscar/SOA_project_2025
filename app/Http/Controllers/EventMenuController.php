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
        $response = Http::get($this->url . "/dish_categories?per_page=100");
        $res = json_decode($response);

        $categories = $res->data->data;
        $pagination = $res->data;

        $data['title'] = "Manage Event Menus";
        $data['categories'] = $categories;
        $data['pagination'] = $pagination;
        return view('pages.service-event.admin.event_menus.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $response = Http::get($this->url . '/dish_categories?per_page=100');
        $res = json_decode($response);

        $categories = is_array($res->data ?? null)
            ? $res->data
            : ($res->data->data ?? []);

        return view('pages.service-event.admin.event_menus.create', [
            'title' => "Create Event Menu",
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $file = $request->file('image');

        $response = Http::attach('image', file_get_contents($file), $file->getClientOriginalName())
            ->post($this->url . '/event_menus', $request->all());
        $res = json_decode($response);

        return $this->success("Event menu created successfully", $res->data ?? null);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menuResponse = Http::get("{$this->url}/event_menus/{$id}");
        $menuRes = json_decode($menuResponse);

        $categoriesResponse = Http::get($this->url . '/dish_categories?per_page=100');
        $categoriesRes = json_decode($categoriesResponse);

        $categories = is_array($categoriesRes->data ?? null)
            ? $categoriesRes->data
            : ($categoriesRes->data->data ?? []);

        return view('pages.service-event.admin.event_menus.edit', [
            'title' => "Edit Event Menu",
            'event_menu' => $menuRes->data ?? null,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $file = $request->file('image');

        if ($file) {
            $response = Http::attach('image', file_get_contents($file), $file->getClientOriginalName())
                ->put($this->url . '/event_menus/' . $id, $request->all());
        } else {
            $response = Http::put($this->url . '/event_menus/' . $id, $request->all());
        }

        $res = json_decode($response);
        if (!$res->success) {
            return $this->error($res->message ?? "Failed to update event menu");
        }

        return $this->success("Event menu updated successfully", $res->data ?? null);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = Http::delete("{$this->url}/event_menus/{$id}");
        $res = json_decode($response);

        return $this->success("Event menu deleted successfully", $res->data ?? null);
    }
}
