@component('mail::message')
@component('mail::title')
# Pending Tools
@endcomponent

There are one or more tools, which are currently pending approval.
To review the new submissions, please click the button below.

{{-- Action --}}
@component('mail::button', ['url' => route('tools')])
View Tools
@endcomponent

{{-- Link Help --}}
@slot('subcopy')
If you are having trouble clicking the button, you can click the following
link, or copy and paste it into your web browser:
[{{ route('tools') }}]({{ route('tools') }})
@endslot
@endcomponent