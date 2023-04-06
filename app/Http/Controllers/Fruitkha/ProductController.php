<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function detailProduct()
    {
        $cart = session()->get("cart");

        return view('client.product.single-product');
    }

    function addToCart(Request $request){
        $product = Products::find($request->id);
        if(empty($product)){
            abort(404);
        }else{
            $cart = session()->get('cart');
            if(empty($cart)){
                $cart = [
                    $product->id => [
                        "id" => $product->id,
                        "name" => $product->name,
                        "thumbnail" => $product->thumbnail,
                        "quantity" => $request->quantity,
                        "price" => $product->price
                    ]
                ];
                session()->put('cart', $cart);
                return redirect()->back();
            }
            if(isset($cart[$product->id])){
                $cart[$product->id]['quantity'] += $request->quantity ;
                session()->put('cart', $cart);
                return redirect()->back();
            }
            $cart = [
                $product->id => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "thumbnail" => $product->thumbnail,
                    "quantity" => 1,
                    "price" => $product->price
                ]
            ];
            session()->put('cart', $cart);
            return redirect()->back();
        }
    }

    function update(Request $request){
        $cart = session()->get('cart');
        if($request->id and $request->quantity){
            $cart[$request->id]['quantity'] = $request->quantity ;
            session()->put('cart', $cart);
        }
    }

    function delete(Request $request){
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
    }
}