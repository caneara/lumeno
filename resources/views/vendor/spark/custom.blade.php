{{-- Favicon (PNG) --}}
<link rel="icon"
      type="image/png"
      href="{{ asset('img/logo.png') }}">

{{-- Favicon (SVG) --}}
<link rel="icon"
      type="image/svg+xml"
      href="{{ asset('img/logo.svg') }}">

{{-- Fonts --}}
<style>

    /**
     * Proxima Vara.
     *
     */
    @font-face {
        font-family: 'Proxima Vara';
        font-style: normal;
        font-weight: 100 900;
        font-variant-numeric: proportional-nums;
        src: url('{{ asset('fonts/ProximaVara.woff2') }}') format('woff2')
    }

    /**
     * Inter.
     *
     */
    @font-face {
        font-family: 'Inter';
        font-style: normal;
        font-weight: 100 900;
        font-variant-numeric: proportional-nums;
        src: url('{{ asset('fonts/Inter.woff2') }}') format('woff2')
    }

</style>

{{-- Styles --}}
<style>
    .font-sans { font-family: 'Proxima Vara' }
    .bg-custom-hex { background-color: {!! config('spark.brand.color') !!} }
    #sideBar h1 { font-family: 'Inter'; letter-spacing: -0.5px; padding-left: 40px; font-size: 20px; background: url('{{ asset('img/logo.png') }}') no-repeat 0% 4px/25px }
    #sideBar h2 { display: none }
    #sideBar h2 + div div + div { color: #000000; font-weight: 500 }
    #sideBar h2 + div + div { margin-top: 3px; font-size: 16px }
    #sideBar h2 + div + div + div { padding-right: 10px; font-size: 15px; font-weight: 450 }
    #sideBar + div h1 { font-family: 'Inter'; font-weight: 600; font-size: 20px; letter-spacing: -0.5px }
    #sideBar + div svg.text-green-400 { color: #059669cc }
    #sideBar + div svg.text-gray-400.w-4.h-4 { height: 11px; width: 11px; position: relative; top: -1px }
    #sideBar + div svg.text-gray-400.w-4.h-4 + div { text-decoration: none; text-transform: uppercase; font-size: 13px; font-weight: 600 }
    #sideBar + div button.bg-custom-hex { font-size: 13px; font-weight: 700; letter-spacing: 0.1px; padding-bottom: 7px; transition-property: background-color; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 300ms }
    #sideBar + div button.bg-custom-hex:hover { background-color: #2b6dab }
    #sideBar + div button.bg-custom-hex[role=checkbox] { background-color: #059669cc }
    #sideBar + div button.bg-white { font-size: 13px; font-weight: 700; letter-spacing: 0.1px; padding-bottom: 7px; color: #666666 }
    #sideBar + div div.px-6.py-4.bg-gray-100 { padding: 14px }
    #sideBarReturnLink a { font-size: 12px }
    #sideBarReturnLink a svg { height: 12px; width: 12px }
    #sideBarReturnLink a div { text-decoration: none; text-transform: uppercase; transition-property: color; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 300ms }
    #sideBarReturnLink a:hover div { color: #be123c }
    #topNavReturnLink { font-size: 12px }
    #topNavReturnLink svg { height: 12px; width: 12px }
    #topNavReturnLink div { text-decoration: none; text-transform: uppercase; transition-property: color; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 300ms }
    #topNavReturnLink:hover div { color: #be123c }
    #topNavReturnLink + div { padding-bottom: 45px }
    .flex-1 .text-sm.text-gray-600 { font-weight: 450 }
    .flex-1 .text-sm.text-gray-600.uppercase { font-weight: 600; font-size: 13px }
</style>