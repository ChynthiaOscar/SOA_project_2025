<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventPackageController extends Controller
{
    use \App\Utils\HttpResponse;
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $search = $request->query('search', '');

        $response = Http::get(env('API_URL') . '/event_packages', [
            'page' => $page,
            'search' => $search,
        ]);

        $res = json_decode($response);

        $data['packages'] = $res->data->data ?? [];
        $data['pagination'] = (object)[
            'current_page' => $res->data->current_page ?? 1,
            'last_page' => $res->data->last_page ?? 1,
        ];
        $data['search'] = $search;

        return view('pages.service-event.admin.event_packages.index', $data);
    }

    public function create()
    {
        $response = Http::get(env('API_URL') . '/event_spaces?per_page=100');
        $res = json_decode($response);

        $eventSpaces = [];
        if ($response->successful() && isset($res->data)) {
            $eventSpaces = is_array($res->data) ? $res->data : ($res->data->data ?? []);
        }
        return view('pages.service-event.admin.event_packages.create', compact('eventSpaces'));
    }

    public function store(Request $request)
    {
        $response = Http::post(env('API_URL') . '/event_packages', [
            'name' => $request->name,
            'description' => $request->description,
            'pax' => $request->pax,
            'price' => $request->price,
            'event_space_id' => $request->event_space_id,
        ]);

        $res = json_decode($response);
        return $this->success("Event packages created successfully", $res->data);
    }

    public function edit(string $id)
    {
        $data['title'] = "Edit Event Package";
        $response = Http::get(env('API_URL') . '/event_packages/' . $id);
        $res = json_decode($response);
        $data['package'] = $res->data;

        // Fetch event spaces for the dropdown
        $eventSpacesResponse = Http::get(env('API_URL') . '/event_spaces?per_page=100');
        $eventSpacesRes = json_decode($eventSpacesResponse);

        $eventSpaces = [];
        if ($eventSpacesResponse->successful() && isset($eventSpacesRes->data)) {
            $eventSpaces = is_array($eventSpacesRes->data) ? $eventSpacesRes->data : ($eventSpacesRes->data->data ?? []);
        }
        $data['eventSpaces'] = $eventSpaces;

        return view('pages.service-event.admin.event_packages.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $response = Http::put(env('API_URL') . '/event_packages/' . $id, $request->all());
        $res = json_decode($response);
        return $this->success("Event package updated successfully", $res->data);
    }

    public function destroy($id)
    {
        $response = Http::delete(env('API_URL') . '/event_packages/' . $id);
        $res = json_decode($response);
        return $this->success("Event package deleted successfully", $res->data);
    }
}
