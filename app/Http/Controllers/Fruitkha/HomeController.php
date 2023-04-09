<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProductRepository;
use Illuminate\Http\Request;
use App\Models\Contacts;
use Carbon\Carbon;
class HomeController extends Controller
{
    protected $productRepo;
    function __construct(ProductRepository $productRepo)
    {
        $this->productRepo=$productRepo;
    }
    function homeViewV1()
    {
        $products=$this->getProductTop3();
        return view('client.home.index',compact("products"));
    }

    function homeViewV2()
    {
        $products=$this->getProductTop3();
        return view('client.home.index-2',compact("products"));
    }
    function aboutUsView(){
        return view('client.about-us.about-us');
    }
    function contactView(){
        
        return view('client.contact.contact');
    }
    function getProductTop3(){
        $products=$this->productRepo->getTop3Product();
        return $products;
    }

  
    function insertContact(Request $request){
        $name=$request->input('name');
        $email=$request->input('email');
        $phone=$request->input('phone');
        $message=$request->input('message');
        $ContactInfo=array(
            'message'=> $message,
            'name'=>$name,
            'phone'=>$phone,
            'email'=>$email,
            'created_at'=>Carbon::now(),
            'updated_at' => Carbon::now()
        );
        Contacts::insert($ContactInfo);
    function dashBoard(){
        return view('admin.Dashborad.dashboard');
    }
    function calendarView(){
        return view("admin.app.calendar");
>>>>>>> dev
    }
}