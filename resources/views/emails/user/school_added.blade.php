@component('mail::message')
# {{ $school->name }} Listed Successfully 🎉

Your school, {{ $school->name }}, has been listed successfully and is pending approval.

We’ll notify you once it’s reviewed and published.

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
