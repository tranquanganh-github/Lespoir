<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function detailProduct()
    {
        $cart = session()->get("cart");

        return view('client.product.single-product');
    }

}