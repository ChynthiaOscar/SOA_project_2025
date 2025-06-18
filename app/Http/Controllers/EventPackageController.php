<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventPackage;
use Illuminate\Support\Facades\Http;

class EventPackageController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get(env('API_URL') . '/event_packages/');
        $res = json_decode($response);
        $data['packages'] = $res->data->data;
        $data['pagination'] = $res->data;
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
