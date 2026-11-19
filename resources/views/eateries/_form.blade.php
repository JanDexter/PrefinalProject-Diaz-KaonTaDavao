{{-- shared by create and edit. $eatery is null on create --}}

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

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="name" class="block text-sm font-medium mb-1">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $eatery?->name) }}"
               class="w-full border border-gray-300 rounded px-3 py-2">
        @error('name')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="district_id" class="block text-sm font-medium mb-1">District</label>
        <select name="district_id" id="district_id" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="">Choose a district</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(old('district_id', $eatery?->district_id) == $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district_id')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="address" class="block text-sm font-medium mb-1">Address</label>
        <input type="text" name="address" id="address" value="{{ old('address', $eatery?->address) }}"
               class="w-full border border-gray-300 rounded px-3 py-2">
        @error('address')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="price_range" class="block text-sm font-medium mb-1">Price range</label>
        <select name="price_range" id="price_range" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="">Choose a price range</option>
            <option value="budget" @selected(old('price_range', $eatery?->price_range) == 'budget')>₱ Budget</option>
            <option value="mid" @selected(old('price_range', $eatery?->price_range) == 'mid')>₱₱ Mid</option>
            <option value="splurge" @selected(old('price_range', $eatery?->price_range) == 'splurge')>₱₱₱ Splurge</option>
        </select>
        @error('price_range')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="specialty" class="block text-sm font-medium mb-1">Specialty (optional)</label>
        <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $eatery?->specialty) }}"
               class="w-full border border-gray-300 rounded px-3 py-2">
        @error('specialty')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        {{-- hidden 0 is sent when the box is unchecked, so it saves as false --}}
        <input type="hidden" name="is_open" value="0">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $eatery?->is_open ?? true))>
            <span class="text-sm font-medium">Open</span>
        </label>
        @error('is_open')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <p class="block text-sm font-medium mb-1">Features</p>
        <div class="flex flex-wrap gap-4">
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                           @checked(in_array($feature->id, old('features', $eatery?->features->pluck('id')->all() ?? [])))>
                    <span class="text-sm">{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>
        @error('features')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
        @error('features.*')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="permit_no" class="block text-sm font-medium mb-1">Permit number</label>
        <input type="text" name="permit_no" id="permit_no" value="{{ old('permit_no', $eatery?->permit?->permit_no) }}"
               placeholder="DVO-2026-0123" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('permit_no')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="expires_on" class="block text-sm font-medium mb-1">Permit expiry date</label>
        <input type="date" name="expires_on" id="expires_on" value="{{ old('expires_on', $eatery?->permit?->expires_on?->format('Y-m-d')) }}"
               class="w-full border border-gray-300 rounded px-3 py-2">
        @error('expires_on')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
