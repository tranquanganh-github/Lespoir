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
        $products=Products::select()->orderBy('created_at','ASC')->limit(3)->get();
        return $products;
    }

    function getAllOfProduct($keyword){
        $size = 10;
        $products = is_null($keyword) ? Products::select() : Products::where(function ($query) use($keyword,$size){
            $query->where("name","like","%$keyword%");
            $query = is_numeric($keyword) ? $query->orwhere(function ($query) use ($keyword,$size){
                return $query->where("price","<",$keyword + $size)->where("price",">",($keyword > $size ? $keyword-$size:$keyword));
            }) : $query;
            return$query;

        });
        return $products->orderBy('created_at','ASC')->paginate(6);
    }

    function getProductByIds($ids){
        $products=Products::whereIn("id",$ids)->get();
        return $products;
    }

}