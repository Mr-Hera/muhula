@component('mail::message')
# Password Reset Request

Hello **{{ $user->first_name }}**,  

You requested to reset your password. Click the button below to choose a new one.

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

If you did not request this, no further action is required.  

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
