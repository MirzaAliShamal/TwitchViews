@extends('layouts.dashboard')

@section('meta')
    <title>TwitchViews - No #1 Twitch Streaming Promotion Platform</title>
@endsection

@section('content')
    <div class="dashboard-header">
        <h3 class="dashboard-header-title">Order History</h3>
        <div class="dashboard-header-action">
            <button type="button" class="btn-secondary btn-sm" data-toggle="modal" data-target="#fetchHistory">+ Fetch History</button>
            <a href="{{ route('home') }}" class="btn-light btn-sm">New Order</a>
        </div>
    </div>

    <div class="dashboard-content">

    </div>


    <div class="modal" id="fetchHistory">
        <div class="modal-content">
            <div class="modal-header">
                <div></div>
                <button type="button" class="modal-close" data-modal="close" data-target="#fetchHistory">
                    <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.698 22.268h.001l-5.712-5.712 5.702-5.701c.469-.47.481-1.241.012-1.71l-.73-.732a1.217 1.217 0 0 0-1.713.011l-5.701 5.702-5.712-5.712a1.202 1.202 0 0 0-1.7-.002l-.735.735a1.2 1.2 0 0 0 .004 1.697l5.712 5.712-5.722 5.722a1.193 1.193 0 0 0 .01 1.692l.73.73a1.19 1.19 0 0 0 1.69.009l5.723-5.722 5.71 5.711c.47.47 1.23.474 1.7.005l.734-.735c.47-.47.467-1.231-.003-1.7z" fill="#000" stroke="#F2F5F8"></path>
                    </svg>
                </button>
            </div>

            <div class="fetch-history">
                <h3>Enter your email to follow the progress on your orders</h3>

                <div class="form-group">
                    <input
                        type="email" name="email" class="form-control required"
                        placeholder="Enter Email Address" autocomplete="off"
                    >
                </div>

                <div class="text-center">
                    <button type="button" class="btn-primary btn-default m-auto historyFetch">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dashboard/js/history.js?v=1.0.10') }}"></script>
@endsection

