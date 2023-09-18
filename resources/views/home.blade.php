@extends('layouts.app')

@section('meta')
    <title>TwitchViews - No #1 Twitch Streaming Promotion Platform</title>
@endsection

@section('content')
    <div class="hero-container wrapper-padding">
        <div class="hero-section">
            <h1>No #1 Twitch Streaming Promotion Platform</h1>
            <p>Please insert & choose your Twitch channel name</p>

            <form action="{{ route('create.order') }}" class="twitch-search">
                <input type="text" class="twitch-search-input" name="twitch_channel" placeholder="Enter & Choose your Twitch channel">
                <div class="twitch-selected d-none">
                    <div class="selected-channel">
                        <div class="selected-channel-thumb">
                            <img src="{{ asset('images/twitchviews-logo-light.png') }}" alt="Channel" class="img-fluid">
                        </div>
                        <div class="selected-channel-meta">
                            <span class="selected-channel-title"></span>
                            <span class="selected-channel-id"></span>
                        </div>
                    </div>
                    <div class="channel-action">
                        <span>Change</span>
                    </div>
                </div>
                <button class="twitch-search-button" type="submit">
                    <span>Start My Promotion</span>
                </button>

                <div class="twitch-search-autocomplete">
                    <div class="twitch-channels">

                    </div>
                </div>
            </form>
            <div class="search-error-wrapper" style="display: none;">Insert & Choose your Twitch channel name to get started</div>
            <p class="font-weight-700">No Login Required &nbsp;&nbsp; | &nbsp;&nbsp; Trust by over 3,455+</p>
        </div>
    </div>

    <div class="how-works-container wrapper-padding">
        <h2 class="container-heading">How TwitchViews works</h2>

        <div class="works-row">
            <div class="works-col">
                <div class="works-step">
                    <div class="works-step-inner">
                        <h2>01</h2>
                    </div>
                </div>
                <h3>Select your Twitch Account</h3>
                <p>
                    Simply enter your twitch username or paste your twitch URL to get started. Make sure to select the correct account,
                    as this is the one that we will be promoting for you.
                </p>
                <button type="button" class="btn-primary btn-default">Grow My Twitch Channel</button>
            </div>
            <div class="works-col">
                <img src="{{ asset('images/how-it-works-1.png') }}" alt="How It Works">
            </div>
        </div>
        <div class="works-row">
            <div class="works-col">
                <img src="{{ asset('images/how-it-works-1.png') }}" alt="How It Works">
            </div>
            <div class="works-col">
                <div class="works-step">
                    <div class="works-step-inner">
                        <h2>02</h2>
                    </div>
                </div>
                <h3>Customize your Twitch order</h3>
                <p>
                    After you select your Twitch account, you are just one step away from finishing your order. Now you can customize your
                    order and let us know exactly how many viewers, followers etc. you are looking to get.
                </p>
                <button type="button" class="btn-primary btn-default">Grow My Twitch Channel</button>
            </div>
        </div>
        <div class="works-row">
            <div class="works-col">
                <div class="works-step">
                    <div class="works-step-inner">
                        <h2>03</h2>
                    </div>
                </div>
                <h3>Finish your order</h3>
                <p>
                    To finish your order, please select one of the available payment methods. We currently support all major credit
                    cards by Visa and Master card.
                </p>
                <button type="button" class="btn-primary btn-default">Grow My Twitch Channel</button>
            </div>
            <div class="works-col">
                <img src="{{ asset('images/how-it-works-3.jpeg') }}" alt="How It Works">
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/search-channel.js') }}"></script>
@endsection
