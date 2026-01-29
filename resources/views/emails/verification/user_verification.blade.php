@component('mail::message')
# Hello {{ $userName }},

Please click the button below to verify your email address.

@component('mail::button', ['url' => $verificationUrl])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
