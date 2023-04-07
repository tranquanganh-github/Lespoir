<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function detailProduct(Request $request)
    {
        $product = Products::find($request->id);
        return view('client.product.single-product',["product" => $product]);
    }

    function addToCart(Request $request){
        $product = Products::find($request->id);
        $cart = session()->get('cart');
        $request->quantity  == null ? $quantity = 1 : $quantity = $request->quantity;
        if(empty($product)){
            abort(404);
        }else{
            if(isset($cart[$product->id])){
                $cart[$product->id]['quantity'] += $quantity;
            }else{
                $cart[$product->id] = [
                    "id" => $product->id,
                    "name" => $product->name,
                    "thumbnail" => $product->thumbnail,
                    "quantity" => $quantity,
                    "price" => $product->price
                ];
            }
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