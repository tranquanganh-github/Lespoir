<?php

namespace App\Http\Repository;

use App\Http\Enum\Status;
use App\Models\OrderDetail;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderRepository
{

    /**
     * tạo chi tiết đơn hàng
     * @param $order_id
     * @param $items
     * @return mixed
     */
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

    /**
     * tạo đơn hàng
     * @param $user_id
     * @param $data
     * @param $getOrder
     * @return false|mixed
     */
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

    /**
     * tìm đơn hàng theo điện thoại
     * @param $phone
     * @param $whitWating
     * @return mixed
     */
    function getOrderByPhone($phone, $whitWating = false)
    {
        $order = Orders::where("code", "=", $phone);
        $order = $whitWating ? $order->where("status", Status::WAITING)
            ->where("created_at", "<", Carbon::now()->endOfDay())
            ->where("created_at", ">", Carbon::now()->startOfDay())
            : $order;
        return $order->get();
    }

    /**
     * tìm đơn hàng theo id
     * @param $id
     * @return mixed
     */
    function getOrderById($id)
    {
        return Orders::whereId($id)->with(["order_details.product"]);
    }

    /**
     * cập nhật đơn hàng theo id
     * @param $id
     * @param $data
     * @return mixed
     */
    function updateOrderById($id, $data)
    {
        return Orders::find($id)->update($data);
    }

    /**
     * lấy ra toàn bộ đơn hàng
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getAllOrder(){
        return Orders::all();
    }
}