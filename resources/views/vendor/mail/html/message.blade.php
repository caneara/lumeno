@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header')
@endcomponent
@endslot

{{-- Body --}}
<div class="content-cell-inner">
    @component('mail::stamp') @endcomponent
    {{ Illuminate\Mail\Markdown::parse($slot) }}
</div>

{{-- Subcopy --}}
@isset($subcopy)
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} Caneara. All rights reserved.
@endcomponent
@endslot
@endcomponent
