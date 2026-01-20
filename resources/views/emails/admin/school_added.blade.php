@component('mail::message')
# New School Listing Pending Approval

A new school has been added to the platform.

**School Name:** {{ $school->name }}

{{-- @component('mail::button', ['url' => route('get.manage.claims')])
Review School Listings
@endcomponent --}}

Thanks,  
**{{ config('app.name') }} System**
@endcomponent
