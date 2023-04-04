<?php

namespace App\Http\Controllers\Fruitkha;

class HomeController
{
    function homeViewV1()
    {
        return view('client.home.index');
    }

    function homeViewV2()
    {
        return view('client.home.index-2');
    }
    function aboutUsView(){
        return view('client.about-us.about-us');
    }
    function contactView(){
        return view('client.contact.contact');
    }
}