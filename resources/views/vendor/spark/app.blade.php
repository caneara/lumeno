{{-- HTML --}}
<!doctype html>
<html lang="{{ app()->getLocale() }}">

    {{-- Head --}}
    <head>

        {{-- Meta --}}
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        {{-- Styles --}}
        <style>
            {!! file_get_contents($cssPath) !!}
        </style>

        {{-- Scripts --}}
        <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js" crossorigin="anonymous"></script>

        {{-- Customization --}}
        @include('vendor.spark.custom')

        {{-- Title --}}
        <title>
            {{ config('app.name') }} - Billing
        </title>

    </head>

    {{-- Body --}}
    <body class="font-sans">

        {{-- Inertia --}}
        @inertia

        {{-- Scripts --}}
        <script>
            window.translations = <?php echo $translations; ?>;

            {!! file_get_contents($jsPath) !!}
        </script>

    </body>

</html>
