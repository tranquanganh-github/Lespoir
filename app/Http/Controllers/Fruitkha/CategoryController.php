<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\CategoryRepository;
use App\Http\Respone\CategoryRespone;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    use CategoryRespone;
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    function table(){
            $categories = $this->categoryRepository->getAllCategory();
            return view("admin.table.category", compact("categories"));
    }

    function formEdit(Request $request){
        $category = $this->categoryRepository->getCategoryById($request->id)->first();
        $url = route('admin.table.categories.update');
        return view('admin.form.category', compact('category','url'));
    }

    function edit(Request $request){
        $messageSuccess = "Update category success!";
        $messageFail = "Update category fail!";
        try {
            $result = $this->categoryRepository->updateCategoryById($request->id,$request->all());
            return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);

        }catch (\Exception $ex){
            return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
        }
    }
    function create(){
        $url = route('admin.form.category');
        return view('admin.form.category', compact('url'));
    }
    function createPost(Request $request){
        $messageSuccess = "Create category success!";
        $messageFail = "Create category fail!";
        try {
            $result = $this->categoryRepository->createCategory($request->all());
            return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
        }catch (\Exception $ex){
            return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
        }
    }
}