@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
    <p class="text-gray-600 mb-6">{{ $user->reviews->count() }} {{ Str::plural('review', $user->reviews->count()) }} written</p>

    <div class="bg-white rounded-lg shadow p-6">
        <ul class="divide-y">
            @forelse ($user->reviews as $review)
                <li class="py-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('eateries.show', $review->eatery) }}" class="font-semibold text-orange-800 hover:underline">{{ $review->eatery->name }}</a>
                        <x-rating :rating="$review->rating" />
                        <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <p class="mt-1">{{ $review->body }}</p>
                </li>
            @empty
                <li class="py-3 text-gray-500">This user has not written any reviews yet.</li>
            @endforelse
        </ul>
    </div>
@endsection
