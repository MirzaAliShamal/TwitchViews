<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DashboardController extends Controller
{
    public function createOrder()
    {
        return view('dashboard.create_order', get_defined_vars());
    }

    public function placeOrder(Request $req)
    {
        if ($req->ajax()) {
            try {
                $user = User::whereEmail($req->email)->first();

                if (is_null($user)) {
                    $user = User::create([
                        'email' => $req->email,
                        'name' => Str::random(6),
                        'password' => 'inbound@1122'
                    ]);
                }

                $rate = 6;
                $charge = ((int)$req->views / 1000) * $rate;

                $cost = 2;
                $formalCharge = ((int)$req->views / 1000) * $cost;

                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Twitch Order',
                        ],
                        'unit_amount' => $charge * 100,
                    ],
                    'quantity' => 1,
                ];

                $session = Session::create([
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => route('payment.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
                    'cancel_url' => route('payment.cancel', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
                ]);

                $order = Order::create([
                    'user_id' => $user->id,
                    'api_order_id' => -1,
                    'channel_name' => $req->channelName,
                    'channel_id' => $req->channelID,
                    'channel_img' => $req->channelImg,
                    'views' => $req->views,
                    'viewers_count' => $req->viewer_count,
                    'join_delay' => $req->join_delay,
                    'charge' => $charge,
                    'formal_charge' => $formalCharge,
                    'profit' => $charge - $formalCharge,
                    'status' => 'not_started',
                ]);

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'stripe_session_id' => $session->id,
                    'payment_method' => 'stripe',
                    'status' => 'pending',
                ]);

                return response()->json([
                    'data' => $user,
                    'redirect_url' => $session->url
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        } else {
            abort(404);
        }
    }

    public function dashboard()
    {
        return view('dashboard.history', get_defined_vars());
    }

    public function history(Request $req)
    {
        if ($req->ajax()) {
            if (isset($req->email)) {
                $user = User::whereEmail($req->email)->first();

                if (!is_null($user)) {
                    $orders = Order::with('user')
                        ->where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(25);

                    if (count($orders) > 0) {
                        return response()->json([
                            'result' => view('dashboard.ajax.history_data', get_defined_vars())->render(),
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => 'No Record Found'
                        ], 404);
                    }
                } else {
                    return response()->json([
                        'message' => 'No Record Found'
                    ], 404);
                }
            } else {
                return response()->json([
                    'message' => 'No Record Found'
                ], 500);
            }
        } else {
            throw new NotFoundHttpException();
        }
    }
}
