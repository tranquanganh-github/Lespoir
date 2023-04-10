<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    function inboxView(){
        return view('admin.email.inbox');
    }
    function readView(){
        return view('admin.email.read');
    }
    function composeView(){
        return view('admin.email.compose');
    }
}