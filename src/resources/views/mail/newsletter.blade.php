@component('mail::message', [
    'mailTitle' => 'BIIGLE Newsletter',
    'mailFooter' => 'You can unsubscribe from the newsletter [here]('.config('app.url').'/newsletter/unsubscribe).',
])
{{ $body }}
@endcomponent
