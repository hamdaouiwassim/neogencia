<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Neogencia Signup Invitation') }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.5;">
    <h2 style="margin-bottom: 8px;">{{ __('You are invited to Neogencia') }}</h2>
    <p>{{ __('Use the link below to create your account. This link can only be used once.') }}</p>

    <p style="margin: 20px 0;">
        <a
            href="{{ $invitation->registrationUrl() }}"
            style="display: inline-block; background: #4f46e5; color: #ffffff; text-decoration: none; padding: 10px 16px; border-radius: 8px;"
        >
            {{ __('Create your account') }}
        </a>
    </p>

    @if($invitation->expires_at)
        <p>{{ __('This invitation expires on :date.', ['date' => $invitation->expires_at->timezone(config('app.timezone'))->format('M j, Y g:i A')]) }}</p>
    @endif

    <p style="margin-top: 16px;">
        {{ __('If the button does not work, copy and paste this URL into your browser:') }}<br>
        <a href="{{ $invitation->registrationUrl() }}">{{ $invitation->registrationUrl() }}</a>
    </p>
</body>
</html>
