@component('mail::message')
# Claim Rejected Notification

Hello Admin,

The claim request for **{{ $school->name }}** has been **rejected**.

User Details:<br>
&nbsp;&nbsp;&nbsp;&nbsp;**Names:** {{ $user->first_name }} {{ $user->last_name }}<br>
&nbsp;&nbsp;&nbsp;&nbsp;**Email:** {{ $user->email }}

@component('mail::button', ['url' => $dashboardUrl])
Go to Dashboard
@endcomponent

Thanks,  
**{{ config('app.name') }} System**
@endcomponent
