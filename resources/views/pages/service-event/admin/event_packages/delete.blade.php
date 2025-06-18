@extends('layouts.app')
@section('title', 'Delete Event Package')
@section('content')
<div class="min-h-screen bg-yellow-50 flex items-center justify-center py-10">
    <div class="bg-white rounded-lg shadow p-8 w-full max-w-md text-center">
        <h1 class="text-xl font-bold text-yellow-900 mb-6">Delete Event Package</h1>
        <p class="mb-6">Are you sure you want to delete <span class="font-semibold">Sample Package</span>?</p>
        <form method="POST" action="{{ route('event_packages.destroy', ['event_package' => 1]) }}">
            @csrf
            @method('DELETE')
            <div class="flex justify-center gap-2">
                <a href="{{ route('event_packages.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded bg-red-500 hover:bg-red-600 text-white font-semibold">Delete</button>
            </div>
        </form>
    </div>
</div>
@endsection
