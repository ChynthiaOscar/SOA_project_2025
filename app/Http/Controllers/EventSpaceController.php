<?php

namespace App\Http\Controllers;

use App\Utils\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventSpaceController extends Controller
{
    use HttpResponse;

    private $url;

    public function __construct()
    {
        $this->url = env("API_URL");
    }

    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $search = $request->query('search');

        $url = $this->url . '/event_spaces?page=' . $page;
        if ($search) {
            $url .= '&search=' . urlencode($search);
        }

        $response = Http::get($url);
        $res = json_decode($response);

        $data['spaces'] = $res->data->data ?? [];
        $data['pagination'] = $res->data ?? null;
        $data['title'] = "Manage Event Spaces";
        $data['search'] = $search;

        return view('pages.service-event.admin.event_spaces.index', $data);
    }

    public function create()
    {
        $data['title'] = "Create Event Space";
        return view('pages.service-event.admin.event_spaces.create', $data);
    }

    public function store(Request $request)
    {
        $response = Http::post($this->url . '/event_spaces', $request->all());
        $res = json_decode($response);
        return $this->success("Event space created successfully", $res->data);
    }

    public function edit(string $id)
    {
        $data['title'] = "Edit Event Space";
        $response = Http::get($this->url . "/event_spaces/" . $id);
        $res = json_decode($response);
        $data['event_space'] = $res->data;
        return view('pages.service-event.admin.event_spaces.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $response = Http::put($this->url . '/event_spaces/' . $id, $request->all());
        $res = json_decode($response);
        return $this->success("Event space updated successfully", $res->data);
    }

    public function destroy($id)
    {
        $response = Http::delete($this->url . '/event_spaces/' . $id);
        $res = json_decode($response);
        return $this->success("Event space deleted successfully", $res->data);
    }
}
