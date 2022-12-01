@component('mail::message')
@component('mail::title')
# Vacancy Invitation
@endcomponent

{{-- Introduction --}}
Great news! {{ $vacancy->organization->name }} has invited you to apply
for the following position that they have available:

{{-- Role --}}
## {{ $vacancy->role }}

{{-- Commitment --}}
@component('mail::icon', ['url' => 'img/icons/calendar.png'])
@if (filled($vacancy->months))
Contract ({{ $vacancy->months }} {{ Str::plural('month', $vacancy->months) }})@component('mail::break') @endcomponent
@else
{{ $vacancy->commitment === 1 ? 'Full Time' : 'Part Time' }}@component('mail::break') @endcomponent
@endif
@endcomponent

{{-- Remuneration --}}
@component('mail::icon', ['url' => 'img/icons/coins.png'])
{{ number_format($vacancy->remuneration) }} {{ $currency . ' per month' }}@component('mail::break') @endcomponent
@endcomponent

{{-- Remote --}}
@component('mail::icon', ['url' => $vacancy->remote ? 'img/icons/remote.png' : 'img/icons/building.png'])
{{ $vacancy->remote ? 'Remote' : 'Not Remote' }}@component('mail::break') @endcomponent
@endcomponent

{{-- Location --}}
@component('mail::icon', ['url' => 'img/icons/globe.png'])
{{ $vacancy->area }}, {{ $country }} ({{ number_format((int) $distance) }} KM)@component('mail::break') @endcomponent
@endcomponent

{{-- Languages --}}
@component('mail::icon', ['url' => 'img/icons/language.png'])
{{ $languages }}
@endcomponent

{{-- Divider --}}
@component('mail::divider') @endcomponent

{{-- Summary --}}
### Summary
{{ $vacancy->summary }}

{{-- Requirements --}}
@component('mail::requirements', ['requirements' => $vacancy->requirements]) @endcomponent

{{-- Divider --}}
@component('mail::divider') @endcomponent

{{-- Contact Information --}}
You can get in contact with {{ $vacancy->organization->name }} about this
position simply by replying to this email. Alternatively, you can use the
following contact information to reach them.

{{-- Divider --}}
@component('mail::divider', ['line' => false, 'margin' => 10]) @endcomponent

{{-- Contact Details --}}
@component('mail::icon', ['url' => 'img/icons/envelope.png'])
[{{ $vacancy->email }}](mailto:{{ $vacancy->email }})@component('mail::break') @endcomponent
@endcomponent
@component('mail::icon', ['url' => 'img/icons/phone.png'])
[{{ $vacancy->phone->formatInternational() }}](tel:{{ $vacancy->phone }})@component('mail::break') @endcomponent
@endcomponent
@component('mail::icon', ['url' => 'img/icons/link.png'])
[{{ $vacancy->website }}]({{ $vacancy->website }})
@endcomponent

{{-- Divider --}}
@component('mail::divider') @endcomponent

{{-- Report Vacancy --}}
@component('mail::small')
If this vacancy needs to be reported, please [contact us]({{ route('support') }})
and quote the following vacancy reference: #{{ $vacancy->id }}
@endcomponent

{{-- User Account --}}
@slot('subcopy')
If you are responsible for the vacancy, then you can view this user's
account by visiting the following link: [{{ $account }}]({{ $account }})
@endslot
@endcomponent