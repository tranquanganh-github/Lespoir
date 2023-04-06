<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
 function tableView(){
     $name = "h";
     return view("data-table",compact("name"));
 }
    function tableView2(){

        return view("data-table");
    }
}