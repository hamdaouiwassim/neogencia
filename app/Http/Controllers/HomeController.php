<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Agent::with(['category', 'user', 'reviews']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by pricing type
        if ($request->filled('pricing_type')) {
            $query->where('pricing_type', $request->pricing_type);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $agents = $query->paginate(12);
        $categories = Category::all();
        $pricingPlans = PricingPlan::all();
        
        // Get featured agents (not filtered by search/filters)
        $featuredAgents = Agent::where('is_featured', true)
            ->with(['category', 'user', 'reviews'])
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        return view('home', compact('agents', 'categories', 'pricingPlans', 'featuredAgents'));
    }
}
