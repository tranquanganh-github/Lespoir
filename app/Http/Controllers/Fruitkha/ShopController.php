<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProductRepository;

class ShopController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    function getListProduct(){
       return $this->productRepository->getList();
}
    function shopView(){
        $prs = $this->getListProduct();
        return view('client.shop.shop');
    }
    function cartView(){
        return view('client.cart.cart');
    }
}