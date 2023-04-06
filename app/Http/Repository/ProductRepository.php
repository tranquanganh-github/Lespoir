<?php

namespace App\Http\Repository;
use App\Models\Products;
use Illuminate\Cache\RateLimiting\Limit;

class ProductRepository
{
    function getTop3Product()
    {
        $products=Products::select()->orderBy('created_at','ASC')->limit(3)->get();
        return $products;
    }

    function getAllOfProduct(){
        $products=Products::select()->orderBy('created_at','ASC')->paginate(6);
        return $products;
    }
}