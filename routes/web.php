<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ChatbotTestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SeoSquadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/agents/explore', [HomeController::class, 'explore'])->name('agents.explore');

// Agent routes - specific routes must come before parameterized routes
Route::middleware('auth')->group(function () {
    Route::get('/agents/my-agents', [AgentController::class, 'index'])->name('agents.my-agents');
    Route::get('/agents/create', [AgentController::class, 'create'])->name('agents.create');
    Route::post('/agents', [AgentController::class, 'store'])->name('agents.store');
    Route::get('/agents/{agent}/edit', [AgentController::class, 'edit'])->name('agents.edit');
    Route::patch('/agents/{agent}', [AgentController::class, 'update'])->name('agents.update');
    Route::delete('/agents/{agent}', [AgentController::class, 'destroy'])->name('agents.destroy');
    Route::post('/agents/{agent}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Public agent routes
Route::get('/agents/{agent}', [AgentController::class, 'show'])->name('agents.show');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Chatbot Test
    Route::get('/chatbot/test', [ChatbotTestController::class, 'index'])->name('chatbot.test');
    Route::post('/chatbot/test', [ChatbotTestController::class, 'test'])->name('chatbot.test.submit');
    
    // SEO Squads
    Route::resource('seo-squads', SeoSquadController::class);
    Route::post('/seo-squads/{seoSquad}/analyze', [SeoSquadController::class, 'analyze'])->name('seo-squads.analyze');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    
    // Agents management
    Route::get('/agents', [App\Http\Controllers\AdminController::class, 'agents'])->name('agents');
    Route::post('/agents/{agent}/approve', [App\Http\Controllers\AdminController::class, 'approveAgent'])->name('agents.approve');
    Route::post('/agents/{agent}/reject', [App\Http\Controllers\AdminController::class, 'rejectAgent'])->name('agents.reject');
    Route::post('/agents/{agent}/feature', [App\Http\Controllers\AdminController::class, 'featureAgent'])->name('agents.feature');
    Route::delete('/agents/{agent}', [App\Http\Controllers\AdminController::class, 'deleteAgent'])->name('agents.delete');
    
    // Users management
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/update-role', [App\Http\Controllers\AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Reviews management
    Route::get('/reviews', [App\Http\Controllers\AdminController::class, 'reviews'])->name('reviews');
    Route::delete('/reviews/{review}', [App\Http\Controllers\AdminController::class, 'deleteReview'])->name('reviews.delete');

    // Chatbot models management
    Route::get('/chatbot-models', [App\Http\Controllers\AdminController::class, 'chatbotModels'])->name('chatbot-models');
    Route::post('/chatbot-models', [App\Http\Controllers\AdminController::class, 'storeChatbotModel'])->name('chatbot-models.store');
    Route::put('/chatbot-models/{chatbotModel}', [App\Http\Controllers\AdminController::class, 'updateChatbotModel'])->name('chatbot-models.update');
    Route::post('/chatbot-models/{chatbotModel}/set-default', [App\Http\Controllers\AdminController::class, 'setDefaultChatbotModel'])->name('chatbot-models.set-default');
    Route::delete('/chatbot-models/{chatbotModel}', [App\Http\Controllers\AdminController::class, 'deleteChatbotModel'])->name('chatbot-models.destroy');

    // Chatbot settings
    Route::get('/chatbot-settings', [App\Http\Controllers\AdminController::class, 'chatbotSettings'])->name('chatbot-settings');
    Route::put('/chatbot-settings', [App\Http\Controllers\AdminController::class, 'updateChatbotSettings'])->name('chatbot-settings.update');
});

require __DIR__.'/auth.php';
