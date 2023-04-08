<?php

namespace App\Http\Respone;

use App\Http\Enum\Status;

trait CheckoutRespone
{
    function responseExistProduct(){
        return  response()->json([
            'status'=> Status::STATUS_MISS_DATA,
            'message'=> 'Product does not exist!',
            'data'=>[],
        ]);
    }
    function responseCreatedOrderSuccessful($data = []){
        return  response()->json([
            'status'=> Status::STATUS_SUCCESS,
            'message'=> 'Successful order creation',
            'data'=>$data
        ]);
    }
    function respomseCreatedOrderFail($data = []){
        return  response()->json([
            'status'=> Status::STATUS_FAIL,
            'message'=> 'Order creation failed',
            'data'=>$data
        ]);
    }
    function responeConformCreateOrder($data = []){
        return  response()->json([
            'status'=> Status::CONFORM,
            'message'=> 'Do you still want to order today?',
            'data'=>$data
        ]);
    }
}