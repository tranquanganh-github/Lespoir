<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\OrderRepository;
use App\Http\Respone\OrderRespone;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use OrderRespone;

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * danh sách đơn hàng cho admin
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function listOrdersAdmin()
    {
        $orders = $this->orderRepository->getAllOrder();
        return view("admin.table.orders", compact("orders"));
    }


    /**
     * cập nhật trạng thái order
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateOrder(Request $request)
    {
        $result = $this->orderRepository->updateOrderById($request->id, ["status" => $request->status]);
        $messageSuccess = "Update order success!";
        $messageFail = "Update order fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    function updateOrderPost(Request $request)
    {
        $result = $this->orderRepository->updateOrderById($request->id, $request->all());
        $messageSuccess = "Update order success!";
        $messageFail = "Update order fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    /**
     * chi tiết đơn hàng
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    function detailOrder(Request $request)
    {
        /*lấy ra đơn hàng cùng với người dùng*/
        $order = $this->orderRepository->getOrderById($request->id)->with(["user"])->first();
        if (is_null($order)) {
            $message = "Not found order !";
            return redirect()->route("admin.table.orders")
                ->with(["message_admin_order" => $message, "status_massage" => "alert alert-danger"]);
        }

        return view("admin.form.order", compact("order"));
    }
}