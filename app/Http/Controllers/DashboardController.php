<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userAgents = Agent::where('user_id', $user->id)
            ->with(['category', 'reviews'])
            ->latest()
            ->limit(5)
            ->get();
        
        $stats = [
            'total_agents' => Agent::where('user_id', $user->id)->count(),
            'total_views' => Agent::where('user_id', $user->id)->sum('views'),
            'total_reviews' => Review::whereHas('agent', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(),
            'average_rating' => Review::whereHas('agent', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->avg('rating') ?? 0,
        ];

        return view('dashboard', compact('userAgents', 'stats'));
    }
}
