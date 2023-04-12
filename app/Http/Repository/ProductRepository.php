<?php

namespace App\Http\Repository;

use App\Models\Contacts;
use App\Models\Products;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ProductRepository
{

    /**
     * lấy ra 3 sản phẩm mới nhất
     * @return mixed
     */
    function getTop3Product()
    {
        $products=Products::select()->where("status",1)->orderBy('created_at','ASC')->limit(3)->get();
        return $products;
    }

    /**
     * lấy sản phẩm theo điều kiện truyền vào
     * @param $request
     * @return mixed
     */
    function getAllOfProduct($request){

        $products = Products::query()->keyword($request)
            ->price($request)
            ->category($request);
        return $products->orderBy('created_at','ASC');
    }

    /**
     * lấy sản phẩm theo ids
     * @param $ids
     * @return mixed
     */
    function getProductByIds($ids){
        $products=Products::whereIn("id",$ids)->get();
        return $products;
    }

    /**
     * lấy sản phẩm theo id
     * @param $id
     * @return mixed
     */
    function getProductById($id){
        return Products::whereId($id);
    }

    /**
     * cập nhật sản phẩm theo id
     * @param $id
     * @param $data
     * @return mixed
     */
    function updateProductById($id, $data){
        return Products::whereId($id)->update($data);
    }

    /**
     * tạo sản phẩm
     * @param $data
     * @return mixed
     */
    function createProduct($data){
        return Products::insert($data);
    }

    /**
     * lấy sản phẩm theo tên
     * @param $name
     * @return mixed
     */
    function getProductByName($name){
        return Products::where("name","=",$name)->where("status",1);
    }

    /**
     * lấy ra sản phẩm đắt nhất và rẻ nhất
     * @return array
     */
    function getMinMaxPrice(){
        $max =  Products::max("price");
        $min =  Products::min("price");
        return [
            "max" => $max,
            "min" => $min
        ];
    }

}