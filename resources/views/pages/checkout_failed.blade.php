@extends('layouts.static')

@section('meta')
    <title>TwitchViews - No #1 Twitch Streaming Promotion Platform</title>
@endsection

@section('content')
<div class="pages-wrapper">
    <img src="{{ asset('images/checkout-failed.png') }}" alt="Success">
    <h2>Payment Failed</h2>
    <p>The payment was unsuccessful. <br> Please try agan later or use another payment method.</p>
    <br><br>
    <h4>We are redirecting you to the "Home" page...</h4>
    <p><small>If you aren't redirected, please click the link below</small></p>
    <a href="{{ route('home') }}">Go to Home</a>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            setTimeout(() => {
                window.location = '/'
            }, 3000);
        });
    </script>
@endsection
