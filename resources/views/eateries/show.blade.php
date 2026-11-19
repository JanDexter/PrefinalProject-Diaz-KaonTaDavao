@extends('layouts.app')

@section('content')
    @php
        $pesos = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
    @endphp

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-orange-800">
                    {{ $eatery->name }}
                    @if (! $eatery->is_open)
                        <span class="align-middle text-sm bg-gray-700 text-white px-2 py-1 rounded">Closed</span>
                    @endif
                </h1>
                <p class="text-gray-600 mt-1">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
                    &middot; {{ $eatery->address }}
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('eateries.edit', $eatery) }}" class="bg-orange-700 text-white px-4 py-2 rounded hover:bg-orange-800">Edit</a>
            </div>
        </div>

        <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div>
                <dt class="text-sm text-gray-500">Price range</dt>
                <dd class="font-semibold text-green-700">{{ $pesos[$eatery->price_range] }} ({{ ucfirst($eatery->price_range) }})</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Specialty</dt>
                <dd>{{ $eatery->specialty ?? 'None' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Status</dt>
                <dd>{{ $eatery->is_open ? 'Open' : 'Closed' }}</dd>
            </div>
        </dl>

        <div class="flex flex-wrap gap-1 mt-4">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                   class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full hover:bg-orange-200">
                    {{ $feature->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- permit box --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-3">Business Permit</h2>
            @if ($eatery->permit)
                <p><span class="text-gray-500">Permit No.:</span> {{ $eatery->permit->permit_no }}</p>
                <p><span class="text-gray-500">Expires on:</span> {{ $eatery->permit->expires_on->format('M d, Y') }}</p>

                @if ($eatery->permit->expires_on->lt(today()))
                    <p class="mt-2 font-semibold text-red-600">Permit expired</p>
                @endif
            @else
                <p class="text-gray-500">No permit on file.</p>
            @endif
        </div>

        {{-- dishes --}}
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            <h2 class="text-xl font-bold mb-3">Dishes</h2>
            <ul class="divide-y">
                @forelse ($eatery->dishes as $dish)
                    <li class="py-2 flex justify-between gap-2">
                        <span>
                            {{ $dish->name }}
                            @if ($dish->is_bestseller)
                                <span class="ml-1 text-xs bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded">Bestseller</span>
                            @endif
                        </span>
                        <span class="font-semibold">₱{{ number_format($dish->price, 2) }}</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">No dishes yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- reviews --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-1">Reviews</h2>
        @if ($eatery->reviews->count() > 0)
            <p class="text-sm text-gray-600 mb-4">
                <x-rating :rating="$eatery->reviews->avg('rating')" />
                {{ number_format($eatery->reviews->avg('rating'), 1) }} ★ ({{ $eatery->reviews->count() }} {{ Str::plural('review', $eatery->reviews->count()) }})
            </p>
        @endif

        <ul class="divide-y mb-6">
            @forelse ($eatery->reviews as $review)
                <li class="py-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('reviewers.show', $review->user) }}" class="font-semibold text-orange-800 hover:underline">{{ $review->user->name }}</a>
                        <x-rating :rating="$review->rating" />
                        <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <p class="mt-1">{{ $review->body }}</p>
                </li>
            @empty
                <li class="py-3 text-gray-500">No reviews yet.</li>
            @endforelse
        </ul>

        @if ($eatery->is_open)
            {{-- review form goes here --}}
        @else
            <p class="text-gray-600 italic">This eatery is closed. Reviews are paused.</p>
        @endif
    </div>
@endsection
