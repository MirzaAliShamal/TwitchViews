@extends('layouts.dashboard')

@section('meta')
    <title>TwitchViews - No #1 Twitch Streaming Promotion Platform</title>
@endsection

@section('content')
    <div class="create-order-wrapper">
        <div>
            <div class="create-order-wrapper-inner">
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-header-inner">
                            <div class="order-channel">
                                <div class="order-channel-img">
                                    <img src="{{ asset('images/twitchviews-logo-light.png') }}" alt="Twitch Channel">
                                </div>
                                <strong>twitch_alps</strong>
                            </div>
                            <div class="order-account">
                                <span>Order Details</span>
                                <h3>$0</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-detail">
                        <div class="order-detail-head">
                            <span>Your Order</span>
                        </div>
                        <div class="order-detail-body your-order">
                            <div class="form-group">
                                <label class="form-label">
                                    Number of views
                                    <span class="more-info" data-toggle="tooltip" data-template="viewsTooltip">
                                        <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity=".9" fill="#000">
                                                <path d="M7.5 11.821a.732.732 0 1 0 0-1.465.732.732 0 0 0 0 1.465z"></path>
                                                <path d="M7.5 0A7.496 7.496 0 0 0 0 7.5C0 11.645 3.354 15 7.5 15c4.145 0 7.5-3.354 7.5-7.5C15 3.355 11.646 0 7.5 0zm0 13.828A6.325 6.325 0 0 1 1.172 7.5 6.325 6.325 0 0 1 7.5 1.172 6.325 6.325 0 0 1 13.828 7.5 6.325 6.325 0 0 1 7.5 13.828z"></path>
                                                <path d="M7.5 3.765a2.346 2.346 0 0 0-2.344 2.343.586.586 0 1 0 1.172 0c0-.646.526-1.171 1.172-1.171.646 0 1.172.525 1.172 1.171 0 .647-.526 1.172-1.172 1.172a.586.586 0 0 0-.586.586v1.465a.586.586 0 1 0 1.172 0v-.953a2.348 2.348 0 0 0 1.758-2.27A2.346 2.346 0 0 0 7.5 3.765z"></path>
                                            </g>
                                        </svg>
                                    </span>

                                    <div style="display: none;" id="viewsTooltip">
                                        <div class="tooltip-header">
                                            Views
                                        </div>
                                        <div class="tooltip-content">
                                            <p>Choose the quantity of "views" to buy.</p>
                                            <p>The more you buy, the longer your order will last</p>
                                            <br>
                                            <p>Minimum: 1000 views</p>
                                            <p>Maximum: 300000 views</p>
                                        </div>
                                    </div>
                                </label>
                                <input
                                    type="text" name="views" id="views"
                                    class="form-control required" placeholder="e.g. 1000"
                                    onkeyup="calcTotal()"
                                    onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
                                    autocomplete="off"
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    Number of viewers
                                    <span class="more-info" data-toggle="tooltip" data-template="viewersTooltip">
                                        <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity=".9" fill="#000">
                                                <path d="M7.5 11.821a.732.732 0 1 0 0-1.465.732.732 0 0 0 0 1.465z"></path>
                                                <path d="M7.5 0A7.496 7.496 0 0 0 0 7.5C0 11.645 3.354 15 7.5 15c4.145 0 7.5-3.354 7.5-7.5C15 3.355 11.646 0 7.5 0zm0 13.828A6.325 6.325 0 0 1 1.172 7.5 6.325 6.325 0 0 1 7.5 1.172 6.325 6.325 0 0 1 13.828 7.5 6.325 6.325 0 0 1 7.5 13.828z"></path>
                                                <path d="M7.5 3.765a2.346 2.346 0 0 0-2.344 2.343.586.586 0 1 0 1.172 0c0-.646.526-1.171 1.172-1.171.646 0 1.172.525 1.172 1.171 0 .647-.526 1.172-1.172 1.172a.586.586 0 0 0-.586.586v1.465a.586.586 0 1 0 1.172 0v-.953a2.348 2.348 0 0 0 1.758-2.27A2.346 2.346 0 0 0 7.5 3.765z"></path>
                                            </g>
                                        </svg>
                                    </span>

                                    <div style="display: none;" id="viewersTooltip">
                                        <div class="tooltip-header">
                                            Viewers
                                        </div>
                                        <div class="tooltip-content">
                                            <p>Choose the amount of real viewers you want to reach.</p>
                                            <br>
                                            <p>Minimum: 5 real viewers</p>
                                            <p>Maximum: 30000 real viewers</p>
                                        </div>
                                    </div>
                                </label>
                                <input
                                    type="text" name="viewer_count" id="viewer_count"
                                    class="form-control required" placeholder="e.g. 5"
                                    onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
                                    autocomplete="off"
                                >
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    Join delay
                                    <span class="more-info" data-toggle="tooltip" data-template="delayTooltip">
                                        <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity=".9" fill="#000">
                                                <path d="M7.5 11.821a.732.732 0 1 0 0-1.465.732.732 0 0 0 0 1.465z"></path>
                                                <path d="M7.5 0A7.496 7.496 0 0 0 0 7.5C0 11.645 3.354 15 7.5 15c4.145 0 7.5-3.354 7.5-7.5C15 3.355 11.646 0 7.5 0zm0 13.828A6.325 6.325 0 0 1 1.172 7.5 6.325 6.325 0 0 1 7.5 1.172 6.325 6.325 0 0 1 13.828 7.5 6.325 6.325 0 0 1 7.5 13.828z"></path>
                                                <path d="M7.5 3.765a2.346 2.346 0 0 0-2.344 2.343.586.586 0 1 0 1.172 0c0-.646.526-1.171 1.172-1.171.646 0 1.172.525 1.172 1.171 0 .647-.526 1.172-1.172 1.172a.586.586 0 0 0-.586.586v1.465a.586.586 0 1 0 1.172 0v-.953a2.348 2.348 0 0 0 1.758-2.27A2.346 2.346 0 0 0 7.5 3.765z"></path>
                                            </g>
                                        </svg>
                                    </span>

                                    <div style="display: none;" id="delayTooltip">
                                        <div class="tooltip-header">
                                            Join Delay
                                        </div>
                                        <div class="tooltip-content">
                                            <p>Choose in how many minutes your "Viewers" should be reached.</p>
                                            <br>
                                            <p>Minimum: 0 minutes (Deactivated)</p>
                                            <p>Maximum: 240 minutes</p>
                                        </div>
                                    </div>
                                </label>
                                <input
                                    type="text" name="join_delay" id="join_delay"
                                    class="form-control required" placeholder="e.g. 30"
                                    onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
                                    autocomplete="off"
                                >
                            </div>
                            <div class="form-group order-total">
                                <p>Total</p>
                                <p class="order-amount">
                                    <span class="converted-amount"></span>
                                    <span class="original-amount">$0</span>
                                </p>
                            </div>

                            <div class="details-action">
                                <button type="button" class="btn-primary btn-default confirm-details">
                                    <span>Next: Confirm Details</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-detail">
                        <div class="order-detail-head">
                            <span>Confirm Details</span>
                        </div>
                        <div class="order-detail-body payment-details" id="paymentDetails">
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    Please enter your email address. This is where we will send you updates on your campaigns.
                                </label>
                                <input
                                    type="email" name="email" id="email"
                                    class="form-control required" placeholder="Email"
                                    autocomplete="off"
                                >
                            </div>

                            <div class="form-group">
                                <div class="custom-checkbox">
                                    <input type="checkbox" class="form-checkbox required" name="agree" id="agree">
                                    <label for="agree" class="terms-label">You agree to our <a href="">Terms</a> & <a href="">Refund Policy</a></label>
                                </div>
                            </div>

                            <div class="order-last-step text-center">
                                <button type="button" class="btn-primary btn-default confirm-payment">Continue to Payment</button>
                            </div>

                            <div class="secure-checkout">
                                <div class="secure-card">
                                    <div class="secure-icon">
                                        <img src="{{ asset('images/shield.png') }}" alt="">
                                    </div>
                                    <p>Guaranteed Safe Checkout</p>
                                </div>
                                <div class="secure-card">
                                    <div class="secure-icon">
                                        <img src="{{ asset('images/padlock.png') }}" alt="">
                                    </div>
                                    <p>Secure SSL Encryption</p>
                                </div>
                                <div class="secure-card">
                                    <div class="secure-icon">
                                        <img src="{{ asset('images/like.png') }}" alt="">
                                    </div>
                                    <p>Performance Guaranteed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dashboard/js/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/tippy-bundle.umd.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/create_order.js?v=1.0.22') }}"></script>
@endsection
