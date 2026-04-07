<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SignupInvitation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Invitation-only signup: explain how to get access.
     */
    public function createLanding(): View
    {
        return view('auth.register-landing');
    }

    /**
     * Show registration form for a valid invitation token.
     */
    public function create(string $token): View
    {
        $invitation = SignupInvitation::where('token', $token)->first();
        if (! $invitation || ! $invitation->isConsumable()) {
            abort(403, __('This invitation link is invalid, expired, or has already been used.'));
        }

        return view('auth.register', ['signupInvitation' => $invitation]);
    }

    /**
     * Handle registration using a valid invitation (single use).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, string $token): RedirectResponse
    {
        return DB::transaction(function () use ($request, $token) {
            $invitation = SignupInvitation::where('token', $token)->lockForUpdate()->first();

            if (! $invitation || ! $invitation->isConsumable()) {
                throw ValidationException::withMessages([
                    'email' => [__('This invitation is no longer valid.')],
                ]);
            }

            $emailRules = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class];
            if ($invitation->email) {
                $emailRules[] = Rule::in([strtolower($invitation->email)]);
            }

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => $emailRules,
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $invitation->update(['used_at' => now()]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        });
    }
}
