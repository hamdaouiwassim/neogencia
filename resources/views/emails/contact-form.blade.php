<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.5; color: #1f2937;">
    <h2 style="margin: 0 0 1rem;">{{ __('Contact form message') }}</h2>
    <p style="margin: 0 0 0.5rem;"><strong>{{ __('Name') }}:</strong> {{ $data['name'] }}</p>
    <p style="margin: 0 0 0.5rem;"><strong>{{ __('Email') }}:</strong> <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
    <p style="margin: 0 0 0.5rem;"><strong>{{ __('Subject') }}:</strong> {{ $data['subject'] }}</p>
    <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 1.5rem 0;">
    <p style="margin: 0; white-space: pre-wrap;">{{ $data['message'] }}</p>
</body>
</html>
