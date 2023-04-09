<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    function tableView(){
     $name = "h";
     return view("data-table",compact("name"));
 }
    function tableView2(){
        return view("data-table");
    }
    function listOrdersAdmin(){
        $orders = $this->orderRepository->getAllOrder();
        return view("admin.table.orders",compact("orders"));
    }
    function createOrderView(){
        return view("admin.form.order");
    }

    function updateOrder(Request $request){
        $result = $this->orderRepository->updateOrderById($request->id, ["status" => $request->status]);
        if ($result) {
            $message = "Update order success!";
            return redirect()->route("admin.table.orders")
                ->with(["message_admin_order" => $message,"status_massage"=>"alert alert-success"]);
        }
       $message = "Update order fail!";
       return redirect()->route("admin.table.orders")
           ->with(["message_admin_order" => $message,"status_massage"=>"alert alert-danger"]);
    }
    function detailOrder(Request $request){
        $order = $this->orderRepository->getOrderById($request->id);
        dd($order->get());
        return view("admin.form.order");
    }
}