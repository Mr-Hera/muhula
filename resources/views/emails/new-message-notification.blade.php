@php
    use Illuminate\Support\Str;

    $profileImagePath = $receiver->profile_image
        ? asset('storage/' . $receiver->profile_image)
        : asset('images/default_user.jpg');
@endphp

@component('mail::message')
# You’ve received a new message!

Hello {{ $receiver->first_name }},

You have a new message from **{{ $sender->first_name }} {{ $sender->last_name }}**.

---
<div style="display: flex; align-items: center; margin-top: 12px; margin-bottom: 20px;">
    <img 
        src="{{ $profileImagePath }}" 
        alt="Profile image" 
        style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 12px;"
    >
    <div>
        <strong>{{ $receiver->first_name }}</strong><br>
        <small style="color: #666;">New message alert</small>
    </div>
</div>

> "{{ Str::limit($message->content, 120) }}"

---

@component('mail::button', ['url' => $viewMessagesUrl])
View Your Messages
@endcomponent

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
