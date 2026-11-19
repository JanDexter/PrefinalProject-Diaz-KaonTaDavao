<?php

namespace App\Http\Controllers;

use App\Models\District;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('eateries')->orderBy('name')->get();

        return view('districts.index', compact('districts'));
    }

    public function show(District $district)
    {
        // same data the eatery card needs on the list page
        $eateries = $district->eateries()
            ->with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('name')
            ->get();

        // counted through the hasManyThrough relationship (district -> eateries -> reviews)
        $reviewCount = $district->reviews()->count();

        return view('districts.show', compact('district', 'eateries', 'reviewCount'));
    }
}
