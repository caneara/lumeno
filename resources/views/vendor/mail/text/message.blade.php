@component('mail::layout')
{{-- Header --}}
@slot('header')
    {{-- Blank --}}
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} Caneara. All rights reserved.
@endcomponent
@endslot
@endcomponent
