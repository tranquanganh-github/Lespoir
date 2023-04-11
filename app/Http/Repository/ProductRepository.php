<?php

namespace App\Http\Repository;

use App\Models\Contacts;
use App\Models\Products;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ProductRepository
{
    function getTop3Product()
    {
        $products=Products::select()->where("status",1)->orderBy('created_at','ASC')->limit(3)->get();
        return $products;
    }

    function getAllOfProduct($request){

        $products = Products::query()->keyword($request)
            ->price($request)
            ->category($request);
        return $products->orderBy('created_at','ASC');
    }

    function getProductByIds($ids){
        $products=Products::whereIn("id",$ids)->get();
        return $products;
    }
    function getProductById($id){
        return Products::whereId($id);
    }
    function updateProductById($id,$data){
        return Products::whereId($id)->update($data);
    }
    function createProduct($data){
        return Products::insert($data);
    }
    function getProductByName($name){
        return Products::where("name","=",$name)->where("status",1);
    }

    function getMinMaxPrice(){
        $max =  Products::max("price");
        $min =  Products::min("price");
        return [
            "max" => $max,
            "min" => $min
        ];
    }

}