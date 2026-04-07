{{ __('You are invited to Neogencia.') }}

{{ __('Use this link to create your account (single-use):') }}
{{ $invitation->registrationUrl() }}

@if($invitation->expires_at)
{{ __('Expires: :date', ['date' => $invitation->expires_at->timezone(config('app.timezone'))->format('M j, Y g:i A')]) }}
@endif
