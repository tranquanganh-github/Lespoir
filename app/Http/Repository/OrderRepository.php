<?php

namespace App\Http\Repository;

use App\Http\Enum\Status;
use App\Models\OrderDetail;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    function createOrderDetail($order_id, $items)
    {
        $data = [];
        foreach ($items as $item) {
            array_push($data, [
                "order_id" => $order_id,
                "product_id" => $item["id"],
                "quantity" => $item["quantity"],
                "price" => $item["unit_price"],
                "status" => Status::ACTIVE
            ]);
        }
        return OrderDetail::insert($data);
    }

    function createOrder($user_id, $data, $getOrder = false)
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
                "message" => isset($data["message"]) ? $data["message"] : "null",
                "name" => $data["name"],
                "email" => $data["email"],
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
            return $getOrder ? $order : $result;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    function getOrderByPhone($phone, $whitWating = false)
    {
        $order = Orders::where("code", "=", $phone);
        $order = $whitWating ? $order->where("status", Status::WAITING)
            ->where("created_at", "<", Carbon::now()->endOfDay())
            ->where("created_at", ">", Carbon::now()->startOfDay())
            : $order;
        return $order->get();
    }

    function getOrderById($id)
    {
        return Orders::whereId($id)->with(["order_details.product"]);
    }

    function updateOrderById($id, $data)
    {
        return Orders::find($id)->update($data);
    }

    function getAllOrder(){
        return Orders::all();
    }
}