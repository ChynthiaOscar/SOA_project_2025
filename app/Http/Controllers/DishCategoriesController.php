<?php

namespace App\Http\Controllers;

use App\Utils\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DishCategoriesController extends Controller
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
        $search = $request->query('search'); // ambil query search

        $url = $this->url . '/dish_categories?page=' . $page;

        if ($search) {
            $url .= '&search=' . urlencode($search);
        }

        $response = Http::get($url);
        $res = json_decode($response);

        $data['categories'] = $res->data->data ?? [];
        $data['pagination'] = $res->data ?? null;
        $data['title'] = "Manage Dish Categories";
        $data['search'] = $search;

        return view('pages.service-event.admin.dish_categories.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = "Create Dish Category";
        return view('pages.service-event.admin.dish_categories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Http::post($this->url . '/dish_categories', $request->all());
        $res = json_decode($response);
        return $this->success("Dish category created successfully", $res->data);
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
        $data['title'] = "Edit Dish Category";
        $response = Http::get($this->url . "/dish_categories/" . $id);
        $res = json_decode($response);
        $data['dish_category'] = $res->data;
        return view('pages.service-event.admin.dish_categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = Http::put($this->url . '/dish_categories/' . $id, $request->all());
        $res = json_decode($response);
        return $this->success("Dish category updated successfully", $res->data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete($this->url . '/dish_categories/' . $id);
        $res = json_decode($response);
        return $this->success("Dish category deleted successfully", $res->data);
    }
}
