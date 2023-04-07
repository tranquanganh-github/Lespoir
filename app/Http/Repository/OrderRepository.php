<?php

namespace App\Http\Repository;

use App\Http\Enum\Status;
use App\Models\OrderDetail;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    function createOrderDetail($order_id,$items){
        $data = [];
        foreach ($items as $item)
        {
            array_push($data,[
                "order_id"=>$order_id,
                "product_id"=>$item["id"],
                "quantity"=>$item["quantity"],
                "price"=>$item["unit_price"],
                "status"=>Status::ACTIVE
            ]);
        }
       return OrderDetail::insert($data);
    }

    function createOrder($user_id, $data)
    {
        DB::beginTransaction();
        try {
            $order = Orders::create([
                "user_id" => $user_id,
                "total_price" => $data["total_price"],
                "shipping_price" => $data["shipping_price"],
                "address" => $data["address"],
                "code" => $data["phone"],
                "cart_id" => $data["cart_id"],
                "message" => $data["message"],
                "name"=>$data["name"],
                "email"=>$data["email"],
                "status" => Status::WAITING,
            ]);
            $items = $data["items"];
            $items = array_map(function ($item) {
                return [
                    "id" => $item["id"],
                    "quantity" => $item["quantity"],
                    "unit_price" => $item["price"],
                ];
            }, $items);
            $result = $this->createOrderDetail($order->id, $items);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    function getOrderByPhone($phone,$whitWating = false){
        $order  = Orders::where("code","=",$phone);
        $order = $whitWating ? $order->where("status",Status::WAITING) : $order;
        return $order->get();
    }
}