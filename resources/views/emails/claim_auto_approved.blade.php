@component('mail::message')
# Congratulations!

Hello,

Your claim for **{{ $claim->school->name }}** has been successfully **approved**.

You can now access your school's features on the platform.

@component('mail::button', ['url' => url('/')])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
