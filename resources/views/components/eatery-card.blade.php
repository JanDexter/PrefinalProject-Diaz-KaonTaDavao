@props(['eatery'])

{{-- needs district, features, reviews_count and reviews_avg_rating loaded in the controller --}}
@php
    $pesos = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
@endphp

<div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2">
    <div class="flex items-start justify-between gap-2">
        <a href="{{ route('eateries.show', $eatery) }}" class="text-lg font-semibold text-orange-800 hover:underline">
            {{ $eatery->name }}
        </a>

        @if (! $eatery->is_open)
            <span class="text-xs bg-gray-700 text-white px-2 py-1 rounded">Closed</span>
        @endif
    </div>

    <p class="text-sm text-gray-600">
        <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
        &middot; <span class="font-semibold text-green-700">{{ $pesos[$eatery->price_range] }}</span>
    </p>

    @if ($eatery->specialty)
        <p class="text-sm">Specialty: {{ $eatery->specialty }}</p>
    @endif

    <div class="flex flex-wrap gap-1">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
               class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full hover:bg-orange-200">
                {{ $feature->name }}
            </a>
        @endforeach
    </div>

    <div class="text-sm mt-auto">
        @if ($eatery->reviews_count > 0)
            <x-rating :rating="$eatery->reviews_avg_rating" />
            <span>{{ number_format($eatery->reviews_avg_rating, 1) }} ★ ({{ $eatery->reviews_count }} {{ Str::plural('review', $eatery->reviews_count) }})</span>
        @else
            <span class="text-gray-500">No reviews yet</span>
        @endif
    </div>
</div>
