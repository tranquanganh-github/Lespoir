<?php

namespace App\Http\Controllers\Fruitkha;

class ShopController
{
    function shopView(){
        return view('client.shop.shop');
    }
    function cartView(){
        return view('client.cart.cart');
    }
}