<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\ChatbotModel;
use App\Models\ChatbotSetting;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_agents' => Agent::count(),
            'total_reviews' => Review::count(),
            'pending_agents' => Agent::where('is_approved', false)->count(),
            'total_views' => Agent::sum('views'),
            'average_rating' => Review::avg('rating') ?? 0,
            'recent_users' => User::latest()->limit(5)->get(),
            'recent_agents' => Agent::with(['user', 'category'])->latest()->limit(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function agents(Request $request)
    {
        $query = Agent::with(['user', 'category', 'reviews']);

        // Filter by approval status
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $agents = $query->latest()->paginate(15);

        return view('admin.agents.index', compact('agents'));
    }

    public function approveAgent(Agent $agent)
    {
        $agent->update(['is_approved' => true]);
        return back()->with('success', 'Agent approved successfully!');
    }

    public function rejectAgent(Agent $agent)
    {
        $agent->update(['is_approved' => false]);
        return back()->with('success', 'Agent rejected successfully!');
    }

    public function deleteAgent(Agent $agent)
    {
        $agent->delete();
        return back()->with('success', 'Agent deleted successfully!');
    }

    public function featureAgent(Agent $agent)
    {
        $agent->update(['is_featured' => !$agent->is_featured]);
        $status = $agent->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Agent {$status} successfully!");
    }

    public function users(Request $request)
    {
        $query = User::withCount(['agents', 'reviews']);

        // Filter by role
        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,creator,admin',
        ]);

        $user->update(['role' => $request->role]);
        return back()->with('success', 'User role updated successfully!');
    }

    public function deleteUser(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function reviews(Request $request)
    {
        $query = Review::with(['user', 'agent']);

        // Filter by rating
        if ($request->has('rating') && $request->rating !== 'all') {
            $query->where('rating', $request->rating);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('agent', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }

    /**
     * Chatbot models management.
     */
    public function chatbotModels()
    {
        $models = ChatbotModel::ordered()->get();
        return view('admin.chatbot-models.index', compact('models'));
    }

    public function storeChatbotModel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'api_name' => 'required|string|max:255',
        ]);

        $isDefault = $request->boolean('is_default');
        if ($isDefault) {
            ChatbotModel::query()->update(['is_default' => false]);
        }

        $sortOrder = ChatbotModel::max('sort_order') + 1;

        ChatbotModel::create([
            'name' => $request->name,
            'api_name' => $request->api_name,
            'is_default' => $isDefault,
            'sort_order' => $sortOrder,
        ]);

        return back()->with('success', 'Chatbot model added successfully!');
    }

    public function updateChatbotModel(Request $request, ChatbotModel $chatbotModel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'api_name' => 'required|string|max:255',
        ]);

        $isDefault = $request->boolean('is_default');
        if ($isDefault) {
            ChatbotModel::where('id', '!=', $chatbotModel->id)->update(['is_default' => false]);
        }

        $chatbotModel->update([
            'name' => $request->name,
            'api_name' => $request->api_name,
            'is_default' => $isDefault,
        ]);

        return back()->with('success', 'Chatbot model updated successfully!');
    }

    public function setDefaultChatbotModel(ChatbotModel $chatbotModel)
    {
        ChatbotModel::query()->update(['is_default' => false]);
        $chatbotModel->update(['is_default' => true]);
        return back()->with('success', 'Default model updated successfully!');
    }

    public function deleteChatbotModel(ChatbotModel $chatbotModel)
    {
        $chatbotModel->delete();
        return back()->with('success', 'Chatbot model deleted successfully!');
    }

    /**
     * Chatbot settings (API params).
     */
    public function chatbotSettings()
    {
        $settings = ChatbotSetting::get();
        return view('admin.chatbot-settings.index', compact('settings'));
    }

    public function updateChatbotSettings(Request $request)
    {
        $request->validate([
            'base_url' => 'required|string|url|max:500',
            'api_key' => 'nullable|string|max:500',
            'temperature' => 'required|numeric|min:0|max:2',
            'max_tokens' => 'required|integer|min:1|max:4096',
        ]);

        $settings = ChatbotSetting::get();
        $data = [
            'base_url' => rtrim($request->base_url, '/'),
            'temperature' => (float) $request->temperature,
            'max_tokens' => (int) $request->max_tokens,
        ];
        if ($request->filled('api_key')) {
            $data['api_key'] = $request->api_key;
        }
        $settings->update($data);

        return back()->with('success', 'Chatbot settings updated successfully!');
    }
}
