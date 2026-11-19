<?php

namespace App\Http\Controllers;

use App\Models\User;

class ReviewerController extends Controller
{
    public function show(User $user)
    {
        $user->load([
            'reviews' => function ($query) {
                $query->orderBy('created_at', 'desc')->orderBy('id', 'desc'); // newest first
            },
            'reviews.eatery',
        ]);

        return view('reviewers.show', compact('user'));
    }
}
