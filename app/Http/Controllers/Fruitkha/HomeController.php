<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProductRepository;
use Illuminate\Http\Request;
use App\Models\Contacts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $productRepo;

    function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * for the client-side home page v1
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
     function homeViewV1()
    {
        $products = $this->getProductTop3();
        return view('client.home.index', compact("products"));
    }

    /**
     * for the client-side home page v2
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function homeViewV2()
    {
        $products = $this->getProductTop3();
        return view('client.home.index-2', compact("products"));
    }

    /**
     * for the client-side about us page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function aboutUsView()
    {
        return view('client.about-us.about-us');
    }

    /**
     * for the client-side contact page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function contactView()
    {
        return view('client.contact.contact');
    }

    /**
     * get the 3 most recently created products
     * @return mixed
     */
    function getProductTop3()
    {
        $products = $this->productRepo->getTop3Product();
        return $products;
    }


    /**
     * record user's contact
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function insertContact(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $message = $request->input('message');
        $ContactInfo = array(
            'message' => $message,
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );

        Contacts::insert($ContactInfo);
        return redirect()->back();
    }

    /**
     * for the admin-side dashboard page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function dashBoard()
    {
        return view('admin.Dashborad.dashboard');
    }

    /**
     * for the admin-side calendar page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function calendarView()
    {
        return view("admin.app.calendar");
    }
}