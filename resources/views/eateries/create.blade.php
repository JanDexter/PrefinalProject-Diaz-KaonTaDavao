@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Add Eatery</h1>

    <form action="{{ route('eateries.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        @include('eateries._form', ['eatery' => null])

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-orange-700 text-white px-4 py-2 rounded hover:bg-orange-800">Save Eatery</button>
            <a href="{{ route('eateries.index') }}" class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">Cancel</a>
        </div>
    </form>
@endsection
