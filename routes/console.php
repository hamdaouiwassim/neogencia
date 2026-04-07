<?php

use App\Models\SignupInvitation;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('signup-invitation:create {email?} {--days= : Expire after this many days (omit for no expiry)}', function (?string $email = null) {
    $days = $this->option('days');
    $expiresAt = $days !== null && $days !== ''
        ? now()->addDays(max(1, (int) $days))
        : null;

    $invitation = SignupInvitation::create([
        'token' => Str::random(64),
        'email' => $email ? strtolower($email) : null,
        'invited_by' => null,
        'expires_at' => $expiresAt,
    ]);

    $this->info($invitation->registrationUrl());
})->purpose('Create a signup invitation URL (CLI / bootstrap)');
