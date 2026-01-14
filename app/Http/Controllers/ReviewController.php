<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $validated['agent_id'] = $agent->id;
        $validated['user_id'] = Auth::id();

        // Check if user already reviewed this agent
        $existingReview = Review::where('agent_id', $agent->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            $existingReview->update($validated);
            return back()->with('success', 'Review updated successfully!');
        }

        Review::create($validated);

        return back()->with('success', 'Review submitted successfully!');
    }
}
