@component('mail::message')
@component('mail::title')
# Hey there!
@endcomponent

You have been invited to join Lumeno by {{ $organization }}.

To sign up for a Lumeno account (and also to join {{ $organization }}), please
click the button below.

{{-- Action --}}
@component('mail::button', ['url' => $url])
Register Now
@endcomponent

{{-- Link Help --}}
@slot('subcopy')
If you are having trouble clicking the button, you can click the following
link, or copy and paste it into your web browser:
[{{ $url }}]({{ $url }})
@endslot
@endcomponent