<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;

class NewController extends Controller
{
    function listNews()
    {
        return view('client.new.new');
    }

    function detailNew()
    {
        return view('client.new.single');
    }

}