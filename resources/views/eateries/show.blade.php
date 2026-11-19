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

                {{-- forms can only send GET/POST, so @method('DELETE') fakes the DELETE verb --}}
                <form action="{{ route('eateries.destroy', $eatery) }}" method="POST" onsubmit="return confirm('Delete this eatery and all its reviews?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
                </form>
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
            <ul class="divide-y divide-gray-200">
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

        <ul class="divide-y divide-gray-200 mb-6">
            @forelse ($eatery->reviews as $review)
                <li class="py-3">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                            <a href="{{ route('reviewers.show', $review->user) }}" class="font-semibold text-orange-800 hover:underline">{{ $review->user->name }}</a>
                            <x-rating :rating="$review->rating" />
                            <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>

                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="shrink-0" onsubmit="return confirm('Delete this review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                    <p class="mt-1">{{ $review->body }}</p>
                </li>
            @empty
                <li class="py-3 text-gray-500">No reviews yet.</li>
            @endforelse
        </ul>

        @if ($eatery->is_open)
            <h3 class="text-lg font-bold mb-3">Write a review</h3>

            @if ($errors->any())
                <div class="mb-4 rounded border border-red-300 bg-red-100 px-4 py-3 text-red-800">
                    <p class="font-semibold">Please fix the following:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('eateries.reviews.store', $eatery) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <div>
                    <label for="user_id" class="block text-sm font-medium mb-1">Reviewer</label>
                    <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Choose a reviewer</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rating" class="block text-sm font-medium mb-1">Rating</label>
                    <select name="rating" id="rating" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Choose a rating</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} {{ Str::plural('star', $i) }}</option>
                        @endfor
                    </select>
                    @error('rating')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="body" class="block text-sm font-medium mb-1">Review</label>
                    <textarea name="body" id="body" rows="4" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="bg-orange-700 text-white px-4 py-2 rounded hover:bg-orange-800">Post Review</button>
                </div>
            </form>
        @else
            <p class="text-gray-600 italic">This eatery is closed. Reviews are paused.</p>
        @endif
    </div>
@endsection
