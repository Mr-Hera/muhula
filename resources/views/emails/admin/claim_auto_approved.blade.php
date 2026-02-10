@component('mail::message')
# Claim Auto Approved

A school claim has been automatically approved.

**School:** {{ $claim->school->name }}

**User Email:** {{ $claim->user->email ?? 'N/A' }}

**Claim ID:** {{ $claim->id }}

@component('mail::button', ['url' => url('/')])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
