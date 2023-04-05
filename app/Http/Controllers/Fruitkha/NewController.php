<?php

namespace App\Http\Controllers\Fruitkha;

class NewController
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