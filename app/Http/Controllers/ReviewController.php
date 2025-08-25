<?php

namespace App\Http\Controllers;

use App\Models\SchoolReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function postReview(Request $request) {
        // dd($request);
        // Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to leave a review. Please log in or sign up.');
        }

        // Validate & sanitize request
        $validated = $request->validate([
            'school_id'   => 'required|exists:schools,id',
            'rating'      => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        // Create review
        SchoolReview::create([
            'school_id'   => $validated['school_id'],
            'user_id'     => Auth::id(),
            'rating'      => $validated['rating'],
            'review_text' => strip_tags($validated['review_text']), // sanitize HTML
        ]);

        return back()->with('success', 'Thank you for submitting your review!');
    }
}
