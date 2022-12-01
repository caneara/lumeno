@component('mail::message')
@component('mail::title')
# Verify Email
@endcomponent

In order to access your account, we need you to confirm your email
address by clicking the 'verify' button below.

{{-- Action --}}
@component('mail::button', ['url' => $url])
Verify Email Address
@endcomponent

{{-- Link Help --}}
@slot('subcopy')
If you are having trouble clicking the button, you can click the following
link, or copy and paste it into your web browser: [{{ $url }}]({{ $url }})
@endslot
@endcomponent