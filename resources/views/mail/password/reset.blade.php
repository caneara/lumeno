@component('mail::message')
@component('mail::title')
# Reset Password
@endcomponent

We received a request to reset your account password. To complete
the process, please click the button below. If you didn't submit
a request to change your password, then please ignore this email.

{{-- Action --}}
@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

{{-- Link Help --}}
@slot('subcopy')
If you are having trouble clicking the button, you can click the following
link, or copy and paste it into your web browser: [{{ $url }}]({{ $url }})
@endslot
@endcomponent