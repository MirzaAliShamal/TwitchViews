<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use UnexpectedValueException;
use App\Jobs\PlaceNewOrderJob;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WebhookController extends Controller
{
    public function stripe()
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }


        switch ($event->type) {
            // Session Completed
            case 'checkout.session.completed':
                $session = $event->data->object;

                $transaction = Transaction::with('order')
                    ->where('stripe_session_id', $session->id)
                    ->first();

                if (!is_null($transaction)) {
                    $transaction->stripe_payment_intent = $session->payment_intent;
                    $transaction->amount_total = ($session->amount_total/100);
                    $transaction->amount_subtotal = ($session->amount_subtotal/100);
                    $transaction->currency = $session->currency;
                    $transaction->status = $session->status;
                    $transaction->save();

                    $order = $transaction->order;

                    if ($order->payment_status === 'unpaid') {
                        $order->payment_status = 'paid';
                        $order->save();

                        $user = $order->user;

                        $apiBody = array(
                            'twitch_id' => $order->channel_id,
                            'price_id' => '1',
                            'number_of_views' => $order->views,
                            'number_of_viewers' => $order->viewers_count,
                            'launch_mode' => 'auto',
                            'smooth_gain' => [
                                'enabled' => $order->join_delay > 0 ? true : false,
                                'minutes' => $order->join_delay > 0 ? $order->join_delay : 0
                            ],
                            'delay_time' => 0,
                        );

                        // dispatch your queue job
                        dispatch(new PlaceNewOrderJob($apiBody, $order, $user));
                    }
                }
                break;
            // Refunded From Stripe
            case 'charge.refunded':
                $charge = $event->data->object;

                $transaction = Transaction::with('order')
                    ->where('stripe_payment_intent', $charge->payment_intent)
                    ->first();

                if (!is_null($transaction)) {
                    $transaction->status = 'refunded';
                    $transaction->save();

                    $order = $transaction->order;
                    $order->payment_status = 'refunded';
                    $order->save();
                }

                break;
            default:
                echo 'Received unknown event type ' . $event->type;
                break;
        }

        return response('');
    }

    public function success(Request $req)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $sessionId = $req->get('session_id');

        try {
            $session = Session::retrieve($sessionId);
            if (!$session) {
                throw new NotFoundHttpException;
            }

            $transaction = Transaction::with('order')
                ->where('stripe_session_id', $session->id)
                ->first();

            if (!$transaction) {
                throw new NotFoundHttpException();
            }

            $transaction->stripe_payment_intent = $session->payment_intent;
            $transaction->amount_total = ($session->amount_total/100);
            $transaction->amount_subtotal = ($session->amount_subtotal/100);
            $transaction->currency = $session->currency;
            $transaction->status = $session->status;
            $transaction->save();

            $order = $transaction->order;

            if ($order->payment_status === 'unpaid') {
                $order->payment_status = 'paid';
                $order->save();

                $user = $order->user;

                $apiBody = array(
                    'twitch_id' => $order->channel_id,
                    'price_id' => '1',
                    'number_of_views' => $order->views,
                    'number_of_viewers' => $order->viewers_count,
                    'launch_mode' => 'auto',
                    'smooth_gain' => [
                        'enabled' => $order->join_delay > 0 ? true : false,
                        'minutes' => $order->join_delay > 0 ? $order->join_delay : 0
                    ],
                    'delay_time' => 0,
                );

                // dispatch your queue job
                dispatch(new PlaceNewOrderJob($apiBody, $order, $user));
            }

            return view('pages.checkout_success', get_defined_vars());
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }

    public function cancel(Request $req)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $sessionId = $req->get('session_id');

        try {
            $session = Session::retrieve($sessionId);

            if (!$session) {
                throw new NotFoundHttpException;
            }

            $transaction = Transaction::with('order')
                ->where('stripe_session_id', $session->id)
                ->first();

            if (!$transaction) {
                throw new NotFoundHttpException();
            }
            $transaction->status = 'canceled';
            $transaction->save();

            $order = $transaction->order;
            $order->payment_status = 'canceled';
            $order->save();

            return view('pages.checkout_failed', get_defined_vars());
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }
}
