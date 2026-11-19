@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Welcome to Kaon Ta! Davao</h1>
    <p class="mb-6 text-gray-600">Find the best carinderias and eateries around Davao City.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-3xl font-bold text-orange-700">{{ $eateryCount }}</p>
            <p class="text-gray-600">Eateries</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-3xl font-bold text-orange-700">{{ $districtCount }}</p>
            <p class="text-gray-600">Districts</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-3xl font-bold text-orange-700">{{ $reviewCount }}</p>
            <p class="text-gray-600">Reviews</p>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-3">Top Rated</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($topRated as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @empty
            <p class="text-gray-500">No reviews yet.</p>
        @endforelse
    </div>
@endsection
