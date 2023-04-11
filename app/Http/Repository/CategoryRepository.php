<?php

namespace App\Http\Repository;

use App\Models\Categories;

class CategoryRepository
{
 function getAllCategory(){
     return Categories::all()->where("status","=",1);
 }
 function getCategoryById($id){
     return Categories::whereId($id);
 }
 function updateCategoryById($id,$data){
     return Categories::whereId($id)->update($data);
 }
 function createCategory($data){
     return Categories::insert($data);
 }
}