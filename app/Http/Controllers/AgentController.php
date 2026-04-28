<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'link' => ['nullable', 'url', 'max:500', Rule::requiredIf(fn () => $request->input('execution_mode', 'external') === 'external')],
            'documentation' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'pricing_type' => 'required|in:free,paid,freemium',
            'execution_mode' => 'required|in:external,hosted',
            'langflow_flow_id' => ['nullable', 'string', 'max:255', Rule::requiredIf(fn () => $request->input('execution_mode') === 'hosted')],
            'langflow_revision' => 'nullable|string|max:64',
            'langsmith_project' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_approved'] = false;
        $validated['execution_mode'] = $validated['execution_mode'] ?? 'external';

        if (($validated['execution_mode'] ?? '') === 'hosted' && empty($validated['link'])) {
            $validated['link'] = config('app.url');
        }

        $agent = Agent::create($validated);

        if ($agent->isHosted()) {
            $agent->update(['link' => route('agents.show', $agent, absolute: true)]);
        }

        return redirect()->route('agents.my-agents')->with('success', 'AI Agent submitted successfully!');
    }

    public function show(Agent $agent)
    {
        // Only show approved agents to non-admins
        if (! $agent->is_approved && (! auth()->check() || ! auth()->user()->isAdmin())) {
            abort(404, 'Agent not found or pending approval.');
        }

        // Only increment views for approved agents
        if ($agent->is_approved) {
            $agent->incrementViews();
        }

        $agent->load(['category', 'user', 'reviews.user']);

        $invocations = collect();
        if (auth()->check()) {
            $u = auth()->user();
            if ((int) $agent->user_id === (int) $u->id || $u->isAdmin()) {
                $invocations = $agent->invocations()->latest()->limit(30)->get();
            }
        }

        return view('agents.show', compact('agent', 'invocations'));
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
            'link' => ['nullable', 'url', 'max:500', Rule::requiredIf(fn () => $request->input('execution_mode', $agent->execution_mode ?? 'external') === 'external')],
            'documentation' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'pricing_type' => 'required|in:free,paid,freemium',
            'execution_mode' => 'required|in:external,hosted',
            'langflow_flow_id' => ['nullable', 'string', 'max:255', Rule::requiredIf(fn () => $request->input('execution_mode') === 'hosted')],
            'langflow_revision' => 'nullable|string|max:64',
            'langsmith_project' => 'nullable|string|max:255',
        ]);

        $agent->update($validated);

        if ($agent->isHosted()) {
            $agent->update(['link' => route('agents.show', $agent, absolute: true)]);
        }

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
