@component('mail::message')
# Claim Under Review

Hello {{ $claim->user->name ?? 'User' }},

Your claim for **{{ $claim->school->name }}** requires **manual review**. 

Our team will review your documents and notify you once the process is completed.

@component('mail::button', ['url' => url('/')])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
