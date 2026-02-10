@component('mail::message')
# Welcome {{ $user->first_name }} 🎉

We’re excited to have you join **{{ config('app.name') }}**!

You can now log in and start exploring your account.

@component('mail::button', ['url' => route('home')])
Go to Homepage
@endcomponent

Thanks for signing up,  
**{{ config('app.name') }} Team**
@endcomponent
