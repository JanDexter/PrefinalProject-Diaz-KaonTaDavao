@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit {{ $eatery->name }}</h1>

    <form action="{{ route('eateries.update', $eatery) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        @include('eateries._form', ['eatery' => $eatery])

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-orange-700 text-white px-4 py-2 rounded hover:bg-orange-800">Update Eatery</button>
            <a href="{{ route('eateries.show', $eatery) }}" class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">Cancel</a>
        </div>
    </form>
@endsection
