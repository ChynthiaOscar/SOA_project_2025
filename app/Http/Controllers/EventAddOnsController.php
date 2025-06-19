<?php

namespace App\Http\Controllers;

use App\Utils\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventAddOnsController extends Controller
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
        $response = Http::get($this->url . '/event_add_ons?page=' . $page);
        $res = json_decode($response);
        $data['add_ons'] = $res->data->data;
        $data['pagination'] = $res->data;
        $data['title'] = "Manage Event Add-Ons";
        return view('pages.service-event.admin.event_add_ons.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = "Create Event Add-Ons";
        return view('pages.service-event.admin.event_add_ons.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Http::post($this->url . '/event_add_ons', $request->all());
        $res = json_decode($response);
        return $this->success("Event Add-Ons created successfully", $res->data);
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
        $data['title'] = "Edit Event Add-Ons";
        $response = Http::get($this->url . "/event_add_ons/" . $id);
        $res = json_decode($response);
        $data['event_space'] = $res->data;
        return view('pages.service-event.admin.event_add_ons.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = Http::put($this->url . '/event_add_ons/' . $id, $request->all());
        $res = json_decode($response);
        return $this->success("Event Add-Ons updated successfully", $res->data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete($this->url . '/event_add_ons/' . $id);
        $res = json_decode($response);
        return $this->success("Event Add-Ons deleted successfully", $res->data);
    }
}
