<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{

    public function create()
    {
        $categories = Category::all();
        return view('agents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'featured_image' => 'nullable|url|max:500',
            'description' => 'required|string',
            'link' => 'required|url',
            'documentation' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'pricing_type' => 'required|in:free,paid,freemium',
        ]);

        $validated['user_id'] = Auth::id();

        Agent::create($validated);

        return redirect()->route('home')->with('success', 'AI Agent submitted successfully!');
    }

    public function show(Agent $agent)
    {
        $agent->incrementViews();
        $agent->load(['category', 'user', 'reviews.user']);
        
        return view('agents.show', compact('agent'));
    }
}
