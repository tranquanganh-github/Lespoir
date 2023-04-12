<?php

namespace App\Http\Repository;

use App\Models\Categories;

class CategoryRepository
{

    /**
     * lấy ra tất cả danh mục sản phẩm
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getAllCategory(){
     return Categories::all()->where("status","=",1);
 }

    /**
     * lấy danh mục theo id
     * @param $id
     * @return mixed
     */
    function getCategoryById($id){
     return Categories::whereId($id);
 }

    /**
     * cập nhật danh mục theo id
     * @param $id
     * @param $data
     * @return mixed
     */
    function updateCategoryById($id, $data){
     return Categories::whereId($id)->update($data);
 }

    /**
     * tạo danh mục
     * @param $data
     * @return mixed
     */
    function createCategory($data){
     return Categories::insert($data);
 }
}