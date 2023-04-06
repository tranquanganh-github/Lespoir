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

//     function getListProduct(){
//     $products=$this->getAllProduct();
//        return $this->productRepository;
// }
    function shopView(){
        $products=$this->getAllProduct();
        return view('client.shop.shop',compact("products"));
    }
    function cartView(){
        return view('client.cart.cart');
    }

    function getAllProduct(){
        $products=$this->productRepository->getAllOfProduct();
        return $products;
    }
}