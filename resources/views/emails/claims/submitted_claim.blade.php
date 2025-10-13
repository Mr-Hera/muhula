@component('mail::message')
# Claim Received

Hi {{ $userName }},

We’ve received your claim request for **{{ $schoolName }}**.  
Our verification team will review your submission within **72 hours**.

You’ll be notified once the review is complete.

@component('mail::button', ['url' => config('app.url')])
Visit {{ config('app.name') }}
@endcomponent

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
