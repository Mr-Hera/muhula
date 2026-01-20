@component('mail::message')
# Claim Received

Hi {{ $userName }},

We’ve received your claim request for **{{ $schoolName }}**.

Before we can process your documents, please verify your email by clicking the button below:
@component('mail::button', ['url' => $verificationUrl])
Verify Email
@endcomponent

Our verification team will review your submission within **72 hours**. You’ll be notified once the review is complete.

{{-- @component('mail::button', ['url' => config('app.url')])
Visit {{ config('app.name') }}
@endcomponent --}}

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
