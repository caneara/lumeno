{{-- HTML --}}
<!doctype html>
<html lang="{{ app()->getLocale() }}">

    {{-- Head --}}
    <head>

        {{-- Meta --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="format-detection" content="telephone=no">
        <meta name="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- SEO --}}
        @include('app.seo')

        {{-- Favicon (PNG) --}}
        <link rel="icon"
              type="image/png"
              href="{{ asset('img/logo.png') }}">

        {{-- Favicon (SVG) --}}
        <link rel="icon"
              type="image/svg+xml"
              href="{{ asset('img/logo.svg') }}">

        {{-- Font Awesome --}}
        <link rel="stylesheet"
              crossorigin="anonymous"
              referrerpolicy="no-referrer"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
              integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" />

        {{-- Vite --}}
        @vite(['resources/js/app.js'])

    </head>

    {{-- Body --}}
    <body class="font-sans leading-none {{ env('APP_DUSK') }}">

        {{-- Routes --}}
        @routes()

        {{-- Inertia --}}
        @inertia()

    </body>

</html>