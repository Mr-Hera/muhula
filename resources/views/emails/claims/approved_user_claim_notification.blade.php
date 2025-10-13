@component('mail::message')
# Claim Approved 🎉

Hello {{ $user->first_name }},

Your claim request for **{{ $school->name }}** has been **approved** successfully.

You can now manage this school under your account.

@component('mail::button', ['url' => $viewSchoolUrl])
View School
@endcomponent

@component('mail::button', ['url' => $dashboardUrl])
Go to Dashboard
@endcomponent

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
