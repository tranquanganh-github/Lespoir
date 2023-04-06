<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    function checkOutView(){
        return view('client.checkout.checkout');
    }
}