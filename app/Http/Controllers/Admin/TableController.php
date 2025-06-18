<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return view('admin.tables.index', compact('tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|integer|unique:tables',
            'seat_count' => 'required|integer|min:1',
        ]);

        Table::create($request->all());
        return back()->with('success', 'Meja berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $table = Table::where('number', $request->number)->firstOrFail();
        $table->update($request->all());

        return back()->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        Table::where('number', $request->number)->delete();
        return back()->with('success', 'Meja berhasil dihapus.');
    }
}
