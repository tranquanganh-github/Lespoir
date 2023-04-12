<?php

namespace App\Http\Repository;

use App\Http\Enum\Status;
use App\Models\CartItem;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\DB;


class CartRepository
{

    /**
     * tạo giỏ hàng
     * @param $user_id
     * @param $items
     * @return null
     */
    function createCart($user_id, $items)
    {
        DB::beginTransaction();
        try {
            $cart = ShoppingCart::create(["user_id" => $user_id, "status" => 1]);
            $items = array_map(function ($item) {
                return [
                    "id" => $item["id"],
                    "quantity" => $item["quantity"],
                    "unit_price" => $item["price"],
                ];
            }, $items);
            $result = $this->createCartItem($cart->id, $items);
            DB::commit();
            return $cart;
        } catch (\Exception $e) {
            DB::rollback();
            return null;
        }
    }


    /**
     * tạo item trong giỏ hàng
     * @param $shopping_cart_id
     * @param $items
     * @return mixed
     */
    function createCartItem($shopping_cart_id, $items)
{
    $data = [];
    foreach ($items as $item) {
        array_push($data, [
            "product_id" => $item["id"],
            "cart_id" => $shopping_cart_id,
            "quantity" => $item["quantity"],
            "unit_price" => $item["unit_price"],
            "status" => Status::ACTIVE
        ]);
    }
    return CartItem::insert($data);
}
}