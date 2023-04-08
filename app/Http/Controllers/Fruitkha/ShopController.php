<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProductRepository;
use Illuminate\Http\Request;

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
    function shopView(Request $request){

        $products=$this->getAllProduct($request->search);
        return view('client.shop.shop',compact("products"));
    }
    function cartView(){
        return view('client.cart.cart');
    }

    function getAllProduct($keyword){
        $products=$this->productRepository->getAllOfProduct($keyword);
        return $products;
    }
}