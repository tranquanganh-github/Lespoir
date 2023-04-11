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

    /**
     * trả về view bảng danh mục cho admin
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function table(){
            $categories = $this->categoryRepository->getAllCategory();
            return view("admin.table.category", compact("categories"));
    }

    /**
     * trả về form chỉnh sửa danh mục cho admin
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function formEdit(Request $request){
        /*tìm danh mục xem có tồn tại hay không*/
        $category = $this->categoryRepository->getCategoryById($request->id)->first();
        $url = route('admin.table.categories.update');
        return view('admin.form.category', compact('category','url'));
    }

    /**
     * thực hiện chỉnh sửa danh mục với dữ liệu được truyền lên
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function edit(Request $request){
        $messageSuccess = "Update category success!";
        $messageFail = "Update category fail!";
        try {
            /*tìm và cập nhật danh mục theo dữ liệu gửi lên*/
            $result = $this->categoryRepository->updateCategoryById($request->id,$request->all());
            /*trả về kết quả cùng với response*/
            return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
        }catch (\Exception $ex){
            /*trả về kết quả thất bại cùng với response*/
            return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
        }
    }

    /**
     *  trả về view tạo danh mục cho admin
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function create(){
        $url = route('admin.form.category');
        /*trả về view cập nhật danh mục cho admin*/
        return view('admin.form.category', compact('url'));
    }

    /**
     * nhận và tạo danh mục do admin yêu cầu
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function createPost(Request $request){
        $messageSuccess = "Create category success!";
        $messageFail = "Create category fail!";
        try {
            /*tạo danh mục với những dữ kiện đã truyền lên*/
            $result = $this->categoryRepository->createCategory($request->all());
            /*trả về kết quả cùng với response*/
            return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
        }catch (\Exception $ex){
            /*trả về kết quả thất bại cùng với response*/
            return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
        }
    }
}