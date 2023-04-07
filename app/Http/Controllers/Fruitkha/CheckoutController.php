<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\CartRepository;
use App\Http\Repository\OrderRepository;
use App\Http\Repository\ProductRepository;
use App\Http\Requests\CheckoutRequest;
use App\Http\Respone\CheckoutRespone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CheckoutController extends Controller
{
    use CheckoutRespone;

    protected $request;
    protected $productRepository;
    protected $orderRepository;
    protected $cartRepository;


    public function __construct(Request           $request,
                                ProductRepository $productRepository,
                                OrderRepository   $orderRepository,
                                CartRepository    $cartRepository)
    {
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    function checkOutView()
    {
        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->route("login.get");
        }
        $products = session()->get("cart");
        $carts = array();
        $sum = 0;
        $ship = 10;
        if (!is_null($products)) {
            foreach ($products as $product) {
                $product = (object)$product;

                array_push($carts, [
                    "id" => $product->id,
                    "quantity" => $product->quantity,
                    "thumbnail" => $product->thumbnail,
                    "name" => $product->name,
                    "price" => $product->price,
                ]);
                $sum += $product->price * $product->quantity;
            }
        }
        return view('client.checkout.checkout', compact("sum", "ship", "user", "carts"));
    }

    function paymentOnDelivery(CheckoutRequest $request)
    {
        $user = Auth::user();
        $orderExist = $this->orderRepository->getOrderByPhone($request->phone, true);
        if (count($orderExist) >= 1) {
            if (!isset($request->confirm) || is_null($request->confirm) || $request->confirm === "true") {
                return $this->responeConformCreateOrder();
            }
        }
        $ids = array_column($request->carts, "id");
        $products = $this->productRepository->getProductByIds($ids)->keyBy("id");
        $diff = array_diff(array_values($ids), array_column($products->toArray(), "id"));

        if (count($diff) > 0) {
            return $this->responseExistProduct();
        }
        $sum = 0;
        foreach ($request->carts as $cart) {
            $product = $products[$cart["id"]];
            $sum += $product->price * $cart["quantity"];
        }
        $shoppingCart = $this->cartRepository->createCart($user->id, $request->carts);
        if (!is_null($shoppingCart)) {
            $order = $this->orderRepository->createOrder($user->id, [
                "items" => $request->carts,
                "address" => $request->address,
                "phone" => $request->phone,
                "total_price" => $sum,
                "shipping_price" => $request->shipping,
                "name" => $request->name,
                "email" => $request->email,
                "message" => $request->message,
                "cart_id" => $shoppingCart->id,
            ]);
        }
        if (!is_null($order)) {
            session()->forget("cart");
            return $this->responseCreatedOrderSuccessful();
        } else {
            return $this->respomseCreatedOrderFail();
        }
    }

    function paymentOnPaypal()
    {
        dd($this->request->all());
    }
}