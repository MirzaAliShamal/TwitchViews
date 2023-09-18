<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrfToken" content="{{ csrf_token() }}">
        <meta name="baseUrl" content="{{ url('/') }}">

        <meta charset="UTF-8">
        <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="icon" href="{{ asset('images/twitchviews-150x150.png') }}" sizes="32x32" />
        <link rel="icon" href="{{ asset('images/twitchviews-300x300.png') }}" sizes="192x192" />
        <link rel="apple-touch-icon" href="{{ asset('images/twitchviews-300x300.png') }}" />
        <meta http-equiv="msapplication-TileImage" content="{{ asset('images/twitchviews-300x300.png') }}">
        @yield('meta')

        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    </head>
    <body>

        @yield('content')

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery-cookie.min.js') }}"></script>
        <script src="{{ asset('js/script.js?v=1.0.12') }}"></script>

        @yield('js')
    </body>
</html>
