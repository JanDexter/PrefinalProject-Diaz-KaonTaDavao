@props(['rating'])

{{-- shows filled and empty stars, rounded to the nearest whole star --}}
@php
    $stars = (int) round($rating);
@endphp

<span {{ $attributes->merge(['class' => 'text-yellow-500']) }} title="{{ $rating }} out of 5">
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $stars)
            ★
        @else
            <span class="text-gray-300">★</span>
        @endif
    @endfor
</span>
