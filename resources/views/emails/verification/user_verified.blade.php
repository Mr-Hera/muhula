@component('mail::message')
# Hello {{ $userName }},

Your email address has been successfully verified. 🎉

You can now enjoy all the features of your account.

@component('mail::button', ['url' => route('home')])
Go to Home
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
