<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventPackage;

class EventPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = EventPackage::query();
        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('id', $request->search);
        }
        $packages = $query->orderBy('id')->get();
        return view('pages.service-event.admin.event_packages.index', [
            'packages' => $packages,
            'search' => $request->search,
        ]);
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
        $package = EventPackage::findOrFail($id);
        $package->delete();
        return redirect('event-packages')->with('success', 'Event package deleted!');
    }
} 