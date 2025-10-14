@component('mail::message')
# New School Claim Submitted

A new school claim has been submitted and is pending review.

**School:** {{ $schoolName }}  
**Submitted by:** {{ $userName }}  
**Email:** {{ $userEmail }}

Please review this claim within **72 hours**.

@component('mail::button', ['url' => $reviewUrl])
Review Claims
@endcomponent

Thanks,  
**{{ config('app.name') }} System**
@endcomponent
