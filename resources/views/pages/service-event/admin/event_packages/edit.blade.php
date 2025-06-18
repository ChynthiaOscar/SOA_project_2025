@extends('layouts.app')
@section('title', 'Edit Event Package')
@section('content')
<div class="min-h-screen bg-yellow-50 flex items-center justify-center py-10">
    <div class="bg-white rounded-lg shadow p-8 w-full max-w-md">
        <h1 class="text-xl font-bold text-yellow-900 mb-6">Edit Event Package</h1>
        <form method="POST" action="{{ url('event-packages/'.$package->id) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $package->name) }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Price</label>
                <input type="number" name="price" value="{{ old('price', $package->price) }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ url('event-packages') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
