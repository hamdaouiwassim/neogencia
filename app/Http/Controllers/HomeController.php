<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Agent;
use App\Models\Category;
use App\Models\PricingPlan;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Agent::where('is_approved', true)->with(['category', 'user', 'reviews']);

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
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
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

        $categories = Category::all();
        $pricingPlans = PricingPlan::all();

        $stats = [
            'approved_agents' => Agent::where('is_approved', true)->count(),
            'users' => User::count(),
            'reviews' => Review::count(),
            'agent_views' => (int) Agent::where('is_approved', true)->sum('views'),
        ];

        $filteredAgents = null;
        if ($request->filled('category')) {
            $filteredAgents = $query->paginate(12)->withQueryString();
        }

        $filterCategory = $request->filled('category')
            ? Category::find($request->category)
            : null;

        $featuredQuery = Agent::where('is_featured', true)
            ->where('is_approved', true)
            ->with(['category', 'user', 'reviews']);
        if ($request->filled('category')) {
            $featuredQuery->where('category_id', $request->category);
        }
        $featuredAgents = $featuredQuery->orderBy('views', 'desc')->limit(6)->get();

        return view('home', compact(
            'categories',
            'pricingPlans',
            'featuredAgents',
            'stats',
            'filteredAgents',
            'filterCategory'
        ));
    }

    public function explore(Request $request)
    {
        $query = Agent::where('is_approved', true)->with(['category', 'user', 'reviews']);

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
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
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

        // Get featured agents (not filtered by search/filters)
        $featuredAgents = Agent::where('is_featured', true)
            ->where('is_approved', true)
            ->with(['category', 'user', 'reviews'])
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        return view('agents.explore', compact('agents', 'categories', 'featuredAgents'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $to = config('mail.contact.to');
        $from = config('mail.from.address');
        $mailer = config('mail.default');

        try {
            Mail::to($to)->send(new ContactFormMail($validated));

            Log::info('Contact form mail sent', [
                'to' => $to,
                'from' => $from,
                'mailer' => $mailer,
            ]);
        } catch (\Throwable $e) {
            report($e);

            Log::error('Contact form mail failed', [
                'message' => $e->getMessage(),
                'to' => $to,
                'from' => $from,
                'mailer' => $mailer,
            ]);

            return back()
                ->withInput()
                ->with('error', __('We could not send your message. Please try again later or email us directly.'));
        }

        $success = __('Thank you for your message. We will get back to you soon.');

        if ($mailer === 'log') {
            $success .= ' '.__('(Mail is in log mode: messages are written to the application log, not delivered by SMTP.)');
        }

        return redirect()->route('contact')->with('success', $success);
    }

    public function aiWorkforce()
    {
        return view('ai-workforce');
    }

    public function privacyPolicy()
    {
        return view('legal.privacy-policy');
    }

    public function termsOfService()
    {
        return view('legal.terms-of-service');
    }
}
