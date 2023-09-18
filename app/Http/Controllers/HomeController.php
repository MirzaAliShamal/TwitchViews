<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function home()
    {
        return view('home', get_defined_vars());
    }

    public function test()
    {
        Mail::send('email.user.order_confirm', get_defined_vars(), function ($message) {
            $message->to('mali70162@gmail.com', 'Mirza Ali Shamal');
            $message->subject('TwitchViews Order Confirmation');
        });
        return view('email.user.order_confirm', get_defined_vars());
    }
}
