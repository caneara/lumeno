{{-- Title --}}
<title>{{ $title }}</title>

{{-- Description --}}
<meta name="description"
      content="{{ $description }}">

{{-- Robots --}}
<meta name="robots"
      content="{{ $robots }}">

{{-- Canonical URL --}}
@if (data_get($meta, 'url', ''))
    <link rel="canonical"
          href="{{ data_get($meta, 'url') }}" />
@endif

{{-- Open Graph (Title) --}}
@if (data_get($meta, 'title', ''))
    <meta property="og:title"
          content="{{ data_get($meta, 'title') }}">
@endif

{{-- Open Graph (Description) --}}
@if (data_get($meta, 'description', ''))
    <meta property="og:description"
          content="{{ data_get($meta, 'description') }}">
@endif

{{-- Open Graph (Type) --}}
@if (data_get($meta, 'type', ''))
    <meta property="og:type"
          content="{{ data_get($meta, 'type') }}">
@endif

{{-- Open Graph (Url) --}}
@if (data_get($meta, 'url', ''))
    <meta property="og:url"
          content="{{ data_get($meta, 'url') }}">
@endif

{{-- Open Graph (Image) --}}
@if (data_get($meta, 'image', ''))
    <meta property="og:image"
          content="{{ data_get($meta, 'image') }}">
@endif

{{-- Open Graph (Image Secure) --}}
@if (data_get($meta, 'image', ''))
    <meta property="og:secure_url"
          content="{{ data_get($meta, 'image') }}">
@endif

{{-- Twitter Card (Type) --}}
@if (data_get($meta, 'twitter', ''))
    <meta name="twitter:card"
          content="{{ data_get($meta, 'twitter.type') }}">
@endif

{{-- Twitter Card (Title) --}}
@if (data_get($meta, 'title', ''))
    <meta name="twitter:title"
          content="{{ data_get($meta, 'title') }}">
@endif

{{-- Twitter Card (Description) --}}
@if (data_get($meta, 'description', ''))
    <meta name="twitter:description"
          content="{{ data_get($meta, 'description') }}">
@endif

{{-- Twitter Card (Image) --}}
@if (data_get($meta, 'image', ''))
    <meta name="twitter:image"
          content="{{ data_get($meta, 'image') }}">
@endif