<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function detailProduct()
    {
        return view('client.product.signle-product');
    }
}