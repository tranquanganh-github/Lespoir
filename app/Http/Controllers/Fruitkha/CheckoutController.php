<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Enum\Status;
use App\Http\Repository\CartRepository;
use App\Http\Repository\OrderRepository;
use App\Http\Repository\ProductRepository;
use App\Http\Requests\CheckoutRequest;
use App\Http\Respone\CheckoutRespone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PHPUnit\Exception;
use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;


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
        $orderExist = $this->orderRepository->getOrderByPhone($request->phone, true, true);
        if (count($orderExist) >= 1) {
            if (!isset($request->confirm) || is_null($request->confirm) || $request->confirm === "true") {
                return $this->responeConformCreateOrder();
            }
        }
        $existItems = $this->checkCartExistProducts($request->carts);
        $products = $existItems["products"];
        if ($existItems["result"]) {
            return $this->responseExistProduct();
        }
        $cartResult = $this->createShoppingCart($request, $products, $user);
        $shoppingCart = $cartResult["shoppingCart"];
        $sum = $cartResult["sum"];
        if (!is_null($shoppingCart)) {
            $order = $this->createOrder($request, $shoppingCart, $sum, $user);
        }
        if (!is_null($order)) {
            session()->forget("cart");
            return $this->responseCreatedOrderSuccessful();
        } else {
            return $this->respomseCreatedOrderFail();
        }
    }

    function paymentOnPaypal(CheckoutRequest $request)
    {
        if (is_null(session()->get("cart"))){
            return $this->responseExistProduct();
        }
        $provider = new ExpressCheckout();
        $provider->setApiCredentials(config("paypal"));
        $user = Auth::user();
        $existItems = $this->checkCartExistProducts($request->carts);
        $products = $existItems["products"];
        if ($existItems["result"]) {
            return $this->responseExistProduct();
        }
        $cartResult = $this->createShoppingCart($request, $products, $user);
        $shoppingCart = $cartResult["shoppingCart"];
        $sum = $cartResult["sum"];
        if (!is_null($shoppingCart)) {
            $order = $this->createOrder($request, $shoppingCart, $sum, $user);
        }
        if (!is_null($order) && $order != false) {
            session()->forget("cart");
            $data = [];
            $data['items'] = array_map(function ($cart) {
                return [
                    "name" => $cart["name"],
                    "price" => $cart["price"],
                    "desc" => "",
                    "qty" => $cart["quantity"],
                ];
            }, $request->carts);
            $data['invoice_id'] = $order->id;
            $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
            $data['return_url'] = route("payment.paypal.success");
            $data['cancel_url'] = route("check-out");
            $data['total'] = $sum;
            $data['shipping_discount'] = 0;
            session()->put([
                "current_order_waitin_paypal" => $order->id,
            ]);
            $options = $this->getOptionPaypal();
            $response = $provider->setCurrency('USD')->addOptions($options)->setExpressCheckout($data, true);

            return $this->responseCreatedOrderSuccessful($response);
        } else {
            return $this->respomseCreatedOrderFail();
        }
    }

    function checkTransaction(Request $request)
    {
        try {
            $provider = new ExpressCheckout();     // To use adaptive payments.      // To use express checkout(used by default).
            $provider->setApiCredentials(config("paypal"));
            $data = [];
            $orderId = session()->get('current_order_waitin_paypal');
            $order = $this->orderRepository->getOrderById($orderId)->first();
            $data["items"] = $order->order_details->map(function ($order_detail) {
                $product = $order_detail->product;
                return [
                    "name" => $product->name,
                    "price" => $product->price,
                    "desc" => "",
                    "qty" => $order_detail->quantity,
                ];
            })->toArray();
            $data['invoice_id'] = $orderId;
            $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
            $data['return_url'] = route("check-out");
            $data['cancel_url'] = route("check-out");

            $total = 0;
            foreach ($data['items'] as $item) {
                $total += $item['price'] * $item['qty'];
            }

            $data['total'] = $total;
            $response = $provider->doExpressCheckoutPayment($data, $request->token, $request->PayerID);
            if ($response["PAYMENTINFO_0_ACK"] === "Success") {
                $result =  $this->orderRepository->updateOrderById($orderId,["status"=>1]);
                session()->forget("current_order_waitin_paypal");
                return redirect()->route("check-out-status")->with(["message_for_checkout" => Status::STATUS_SUCCESS]);
            } else {
                session()->forget("current_order_waitin_paypal");
                return redirect()->route("check-out-status")->with(["message_for_checkout" => Status::STATUS_FAIL]);
            }
        } catch (Exception $es) {
            return  redirect()->route("check-out-status")->with(["message_for_checkout" => Status::STATUS_FAIL]);
        }
    }

    function checkCartExistProducts($carts)
    {
        $ids = array_column($carts, "id");
        $products = $this->productRepository->getProductByIds($ids)->keyBy("id");
        $diff = array_diff(array_values($ids), array_column($products->toArray(), "id"));
        if (count($diff) > 0) {
            return [
                "result" => true,
                "products" => array(),
            ];
        }
        return [
            "result" => false,
            "products" => $products,
        ];
    }

    function createShoppingCart($request, $products, $user)
    {
        $sum = 0;
        foreach ($request->carts as $cart) {
            $product = $products[$cart["id"]];
            $sum += $product->price * $cart["quantity"];
        }
        $shoppingCart = $this->cartRepository->createCart($user->id, $request->carts);
        return [
            "sum" => $sum,
            "shoppingCart" => $shoppingCart,
        ];
    }

    function createOrder($request, $shoppingCart, $sum, $user)
    {
        return $this->orderRepository->createOrder($user->id, [
            "items" => $request->carts,
            "address" => $request->address,
            "phone" => $request->phone,
            "total_price" => $sum,
            "shipping_price" => $request->shipping,
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message,
            "cart_id" => $shoppingCart->id,
        ], true);
    }

    function getOptionPaypal()
    {
        return [
            'BRANDNAME' => 'Fruitkha',
            'LOGOIMG' => 'https://themewagon.github.io/fruitkha/assets/img/logo.png',
            'CHANNELTYPE' => 'Merchant'
        ];
    }
    function viewMessage(){
        return view("client.checkout.status.paypal");
    }
}