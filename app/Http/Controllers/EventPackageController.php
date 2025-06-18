<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventPackage;
use Illuminate\Support\Facades\Http;

class EventPackageController extends Controller
{
    public function index(Request $request)
{
    $page = $request->query('page', 1);
    $search = $request->query('search', '');

    $response = Http::get(env('API_URL') . '/event_packages', [
        'page' => $page,
        'search' => $search,
    ]);

    $res = json_decode($response);

    $data['packages'] = $res->data->data;
    $data['pagination'] = (object)[
        'current_page' => $res->data->current_page,
        'last_page' => $res->data->last_page,
    ];
    $data['search'] = $search;

    return view('pages.service-event.admin.event_packages.index', $data);
}


    public function create()
    {
        return view('pages.service-event.admin.event_packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
        ]);
        EventPackage::create($request->only('name', 'price'));
        return redirect('event-packages')->with('success', 'Event package created!');
    }

    public function edit($id)
    {
        $package = EventPackage::findOrFail($id);
        return view('pages.service-event.admin.event_packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
        ]);
        $package = EventPackage::findOrFail($id);
        $package->update($request->only('name', 'price'));
        return redirect('event-packages')->with('success', 'Event package updated!');
    }

    public function destroy($id)
    {
        $response = Http::delete(env('API_URL') . '/event_packages/' . $id);
        $res = json_decode($response);
        return redirect('event-packages')->with('success', 'Event package deleted!');
    }
}
