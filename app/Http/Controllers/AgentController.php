<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::where('user_id', Auth::id())
            ->with(['category', 'reviews'])
            ->latest()
            ->paginate(12);
        
        return view('agents.index', compact('agents'));
    }

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
        $validated['is_approved'] = false; // New agents need admin approval

        Agent::create($validated);

        return redirect()->route('agents.my-agents')->with('success', 'AI Agent submitted successfully!');
    }

    public function show(Agent $agent)
    {
        // Only show approved agents to non-admins
        if (!$agent->is_approved && (!auth()->check() || !auth()->user()->isAdmin())) {
            abort(404, 'Agent not found or pending approval.');
        }

        // Only increment views for approved agents
        if ($agent->is_approved) {
            $agent->incrementViews();
        }
        
        $agent->load(['category', 'user', 'reviews.user']);
        
        return view('agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        // Ensure user owns this agent
        if ($agent->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('agents.edit', compact('agent', 'categories'));
    }

    public function update(Request $request, Agent $agent)
    {
        // Ensure user owns this agent
        if ($agent->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

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

        $agent->update($validated);

        return redirect()->route('agents.my-agents')->with('success', 'Agent updated successfully!');
    }

    public function destroy(Agent $agent)
    {
        // Ensure user owns this agent
        if ($agent->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $agent->delete();

        return redirect()->route('agents.my-agents')->with('success', 'Agent deleted successfully!');
    }
}
