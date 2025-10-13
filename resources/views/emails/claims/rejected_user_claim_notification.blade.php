@component('mail::message')
# Claim Rejected

Hello {{ $user->first_name }},

Your claim request for **{{ $school->name }}** has been **rejected**.

If you believe this was an error, please reach out to our support team for clarification.

@component('mail::button', ['url' => $dashboardUrl])
Go to Dashboard
@endcomponent

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
