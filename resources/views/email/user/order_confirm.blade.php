<!DOCTYPE html>
<html lang="en">
<head>
    <style>html,body { padding: 0; margin:0; }</style>
</head>
<body>
<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
		<tbody>
			<tr>
				<td align="center" valign="center" style="text-align:center; padding: 40px;">
					<a href="{{ route('home') }}" target="_blank" style="display: flex;flex-direction: row;align-items: center;justify-content:center;gap: 0.5rem;text-decoration:none;">
                        <img src="{{ asset('images/twitchviews-logo-light.png') }}" alt="Logo" style="width: 30px;">
                        <span style="font-size: 1.125rem;font-weight:700;color:#04091e;text-decoration:none;">TwitchViews</span>
                    </a>
					<tr>
						<td align="left" valign="center">
							<div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
								<!--begin:Email content-->
								<div style="padding-bottom: 10px; font-size: 17px;">
									<strong>Hi!</strong>
                                </div>
                                <p>
                                    Thank you for making your order with TwitchViews.
                                </p>
                                <p>
                                    We have received your TwitchViews order and will get started with the delivery. Live viewers will take
                                    up to 15 minutes to arrive on your stream. We will start
                                    delivering within 24-48 hours but and the orders are delivered paced over time rather than all at
                                    once.
                                </p>
                                <p>
                                    To track the orders in your TwitchViews dashboard, you can fetch history through your email.
                                </p>
                                <p>
                                    <strong>Order ID:</strong> #{{ $order->id }} <br>
                                    <strong>Number of Views:</strong> {{ $order->views }} <br>
                                    <strong>Number of Viewers:</strong> {{ $order->viewers_count }} <br>
                                    <strong>Join Delay:</strong> {{ $order->join_delay }} <br>
                                    <strong>Total Amount:</strong> {{ $order->charge }}$
                                </p>
                                <br>

                                <p>
                                    <strong>Here are some important things you need to know:</strong>
                                </p>

                                <p>
                                    Your campaign will start delivering withing 24-48 hours.
                                </p>
                                <p>
                                    While your TwitchViews promotionis live, we advise that you do not run other marketing campaigns.
                                    This is because we track your pblic Twitch metrics, such as viewers, and running other
                                    campaigns could interfere with our efforts to optimize your results. <br>
                                    If you are running camapaigns with other providers at the same time, please beaware that it may be
                                    difficult to accurately track our performance.
                                </p>
                                <p>
                                    If your campaign has not started within 48 hours, please contact us at support@twitchviews.com with
                                    your Order ID and we will check.
                                </p>
								<!--end:Email content-->
								<div style="padding-bottom: 10px">Thanks in advance!
								<br>TwitchViews Support Team
								<tr>
									<td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
										<p>Copyright ©
										<a href="{{ route('home') }}" target="_blank">TwitchViews</a>.</p>
									</td>
								</tr></br></div>
							</div>
						</td>
					</tr>
				</td>
			</tr>
		</tbody>
	</table>
</div>

</body>
</html>
