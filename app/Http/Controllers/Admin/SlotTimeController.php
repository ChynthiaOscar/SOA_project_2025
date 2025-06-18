<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlotTime;
use Illuminate\Http\Request;

class SlotTimeController extends Controller
{
    public function index()
    {
        $slots = SlotTime::orderBy('date')->orderBy('start_time')->get();
        return view('admin.slots.index', compact('slots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'date' => 'required|date',
        ]);

        SlotTime::create($request->all());
        return back()->with('success', 'Slot waktu berhasil ditambahkan.');
    }

    public function destroy(Request $request)
    {
        SlotTime::destroy($request->slot_id);
        return back()->with('success', 'Slot waktu berhasil dihapus.');
    }
}
