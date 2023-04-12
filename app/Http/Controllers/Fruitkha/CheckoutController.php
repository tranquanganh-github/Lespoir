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

use Illuminate\Support\Facades\Mail;
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

    /**
     * trả về view cho người dùng kiểm tra giỏ hàng trước khi tiến hành thanh toán
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function checkOutView()
    {
        /*kiểm tra lại lần nữa người dùng đã đăng nhập chưa*/
        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->route("login.get");
        }
        /*lấy ra danh sách giỏ hàng trong session*/
        $products = session()->get("cart");
        $carts = array();
        $sum = 0;
        $ship = 10;
        /*tiến hành add dữ liệu từ session và một mảng*/
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
        /*trả về view cho người dùng*/
        return view('client.checkout.checkout', compact("sum", "ship", "user", "carts"));
    }

    /**
     * tiến hành thanh toán theo hình thức trả tiền khi nhận hàng
     * @param CheckoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function paymentOnDelivery(CheckoutRequest $request)
    {
        $user = Auth::user();
      /*  kiểm tra xem đơn hàng đã tồn tại trước chưa
        tránh trường hợp khác hàng bấm nhầm nút thanh toán lại*/
        $orderExist = $this->orderRepository->getOrderByPhone($request->phone, true, true);
        if (count($orderExist) >= 1) {
            if (!isset($request->confirm) || is_null($request->confirm) || $request->confirm === "true") {
                /*xác định lại xem khách hàng có chắc chắn thanh toán đơn hàng giống với đơn vừa thanh toán ko không*/
                return $this->responeConformCreateOrder();
            }
        }
//         kiểm tra xem sản phẩn trong giỏ hàng có tồn tại không
        $existItems = $this->checkCartExistProducts($request->carts);
        $products = $existItems["products"];
        if ($existItems["result"]) {
            /*nếu không thì thông báo cho người dùng*/
            return $this->responseExistProduct();
        }
        /*lưu giỏ hàng vào DB*/
        $cartResult = $this->createShoppingCart($request, $products, $user);
        $shoppingCart = $cartResult["shoppingCart"];
        $sum = $cartResult["sum"];
        if (!is_null($shoppingCart)) {
            /*tiến hành tạo đơn hàng*/
            $order = $this->createOrder($request, $shoppingCart, $sum, $user);
        }
        if (!is_null($order)) {
            /*nếu đơn hàng được tạo thành công thì clear sesion */
            session()->forget("cart");
            /*trả về thông báo đặt hàng thành công */
            return $this->responseCreatedOrderSuccessful();
        } else {
            /*trả về thông báo là đặt hàng thất bại*/
            return $this->respomseCreatedOrderFail();
        }
    }

    /**
     * tiến hành thanh toán theo hình thức thanh toán online(Paypal)
     * @param CheckoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function paymentOnPaypal(CheckoutRequest $request)
    {
        /*kiểm tra xem giỏi hàng trong session có bị rỗng hay không*/
        if (is_null(session()->get("cart"))){
            return $this->responseExistProduct();
        }
        /*khởi tạo một đỗi tượng checkout của paypal cùng với config*/
        $provider = new ExpressCheckout();
        $provider->setApiCredentials(config("paypal"));
        $user = Auth::user();
        /*tín hành kiểm tra sản phẩm trong giỏ hàng có tồn tại hay không*/
        $existItems = $this->checkCartExistProducts($request->carts);
        $products = $existItems["products"];
        if ($existItems["result"]) {
            /*thông báo sản phẩm trong giỏ hàng không tồn tại*/
            return $this->responseExistProduct();
        }
        /*tạo giỏ hàng trong DB*/
        $cartResult = $this->createShoppingCart($request, $products, $user);
        $shoppingCart = $cartResult["shoppingCart"];
        $sum = $cartResult["sum"];
        if (!is_null($shoppingCart)) {
            /*tạo đơn hàng ở trạng thái chờ thanh toán*/
            $order = $this->createOrder($request, $shoppingCart, $sum, $user);
        }
        if (!is_null($order) && $order != false) {
            /*clear giỏ hàng trong session*/
            session()->forget("cart");
            $data = [];
            /*tạo dự liệu để gửi api qua paypal*/
            $data['items'] = array_map(function ($cart) {
                return [
                    "name" => $cart["name"],
                    "price" => $cart["price"],
                    "desc" => "",
                    "qty" => $cart["quantity"],
                ];
            }, $request->carts);
            /*tiêu đề thanh toán trang paypal*/
            $data['invoice_id'] = $order->id;
            $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
            $data['return_url'] = route("payment.paypal.success");
            /*webhook để paypal gọi khi khách hàng chấp nhận thanh toán*/
            $data['cancel_url'] = route("check-out");
            $data['total'] = $sum;
            $data['shipping_discount'] = 0;
            /*tạo một session cho đơn hàng chờ thanh toán*/
            session()->put([
                "current_order_waitin_paypal" => $order->id,
            ]);
            $options = $this->getOptionPaypal();
            /*tiến hành gửi api lên paypal để lấy đường dẫn xác thực user*/
            $response = $provider->setCurrency('USD')->addOptions($options)->setExpressCheckout($data, true);
            /*trả về phía clien url để redirect */
            return $this->responseCreatedOrderSuccessful($response);
        } else {
            /*thông báo thanh toán thất bại*/
            return $this->respomseCreatedOrderFail();
        }
    }

    /**
     * webhook tiến hành chuyển tiền tài khoản paypal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function checkTransaction(Request $request)
    {
        try {
            $provider = new ExpressCheckout();
            $provider->setApiCredentials(config("paypal"));
            $data = [];
            /*lấy ra đơn hàng đã lưu trên session khi tiến hành xác thực người dùng paypal*/
            $orderId = session()->get('current_order_waitin_paypal');
            /*tìm kiếm đơn hàng theo id*/
            $order = $this->orderRepository->getOrderById($orderId)->first();
            /*chuẩn bị dữ liệu để tiến hành chuyển khoản*/
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
            /*webhook khi hủy thanh toán hoặc thanh toán thành công*/
            $data['return_url'] = route("check-out");
            $data['cancel_url'] = route("check-out");

            $total = 0;
            foreach ($data['items'] as $item) {
                $total += $item['price'] * $item['qty'];
            }

            $data['total'] = $total;
            /*api chuyển khoản*/
            $response = $provider->doExpressCheckoutPayment($data, $request->token, $request->PayerID);
            if ($response["PAYMENTINFO_0_ACK"] === "Success") {
                /*thanh toán thành công thì cập nhật lại trạng thái đơn hàng là paid*/
                $result =  $this->orderRepository->updateOrderById($orderId,["status"=>1]);
                if ($request){
                    /*gửi mail thanh toán*/
                    Mail::to($order->email)->send(new \App\Mail\OrderMail($order->toArray()));
                }
                /*tiến hành clear session đơn hàng đang chờ vừa tạo khi xác thực người dùng paypal*/
                session()->forget("current_order_waitin_paypal");
                /*thông báo thanh toán thành công*/
                return redirect()->route("check-out-status")->with(["message_for_checkout" => Status::STATUS_SUCCESS]);
            } else {
                /*tiến hành clear session đơn hàng đang chờ vừa tạo khi xác thực người dùng paypal*/
                session()->forget("current_order_waitin_paypal");
                /*thanh toán thất bại*/
                return redirect()->route("check-out-status")->with(["message_for_checkout" => Status::STATUS_FAIL]);
            }
        } catch (Exception $es) {
            return  redirect()->route("check-out-status")->with(["message_for_checkout" => Status::STATUS_FAIL]);
        }
    }

    /**
     * kiểm tra xem sản phẩm trong giỏ hàng có tồn tại không
     * @param $carts
     * @return array
     */
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

    /**
     * tiến hành tạo giỏ hàng trong DB
     * @param $request
     * @param $products
     * @param $user
     * @return array
     */
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

    /**
     * tạo đơn hàng trong DB
     * @param $request
     * @param $shoppingCart
     * @param $sum
     * @param $user
     * @return false
     */
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

    /**
     * option config phía paypal
     * @return string[]
     */
    function getOptionPaypal()
    {
        return [
            'BRANDNAME' => 'Fruitkha',
            'LOGOIMG' => 'https://themewagon.github.io/fruitkha/assets/img/logo.png',
            'CHANNELTYPE' => 'Merchant'
        ];
    }

    /**
     * view thông báo trạng thái thanh toán
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function viewMessage(){
        return view("client.checkout.status.paypal");
    }
}