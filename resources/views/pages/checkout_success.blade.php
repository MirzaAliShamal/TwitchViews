@extends('layouts.static')

@section('meta')
    <title>TwitchViews - No #1 Twitch Streaming Promotion Platform</title>
@endsection

@section('content')
<div class="pages-wrapper">
    <img src="{{ asset('images/checkout-success.png') }}" alt="Success">
    <h2>Your Payment is Successfull</h2>
    <p>Thank you for your payment. <br> An automated payment receipt will be sent to your email.</p>
    <br><br>
    <h4>We are redirecting you to the "My Orders" page...</h4>
    <p><small>If you aren't redirected, please click the link below</small></p>
    <a href="{{ route('dashboard') }}">Go to My Orders</a>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            setTimeout(() => {
                window.location = '/user/dashboard'
            }, 3000);
        });
    </script>
@endsection
