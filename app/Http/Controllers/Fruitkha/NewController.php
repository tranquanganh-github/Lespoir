<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\NewRepository;
use App\Models\Cloundinary;
use App\Models\News;
use App\Http\Respone\NewRespone;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NewController extends Controller
{
    use NewRespone;

    protected NewRepository $newRepository;

    public function __construct(NewRepository $newRepository)
    {
        $this->newRepository = $newRepository;
    }

    /**
     * List all news to new page (client).
     */
    function listNews(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $news = News::select()->orderBy('created_at')->with("user")->paginate(6);
        return view('client.new.new', compact('news'));
    }

    /**
     * List all news in store to display (admin).
     */
    function listNewsAdmin(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $news = News::select()->orderBy('created_at')->get();
        return view('admin.table.news', compact('news'));
    }

    /**
     * Detail new (client).
     * @param Request $request
     * @return Factory|View|Application
     */
    function detailNew(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $new = News::find($request->id);
        return view('client.new.single', compact('new'));
    }

    /**
     * Detail new (admin).
     * @param Request $request
     * @return Factory|View|Application
     */
    function editNewView(Request $request): Factory|View|Application
    {
        $new = News::find($request->id);
        $url = route("admin.form.new.edit");
        return view('admin.form.new', compact('new', 'url'));
    }

    function createNewView()
    {
        $url = route("admin.form.new");
        return view('admin.form.new', compact('url'));
    }

    function createnewPost(Request $request)
    {
        $data = $request->all();
        $messageSuccess = "Create new success!";
        $messageFail = "Create new fail!";
        $colud = new Cloundinary();
        //check Product name exist
//        $productIsExist = $this->checkProductExist($request->title);
//        if ($productIsExist == true){
//            $messageFail = "Tên bài viết đã tồn tại";
//            return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
//        }
        if (isset($request->img) && !is_null($request->img) ){
            /*upload file ảnh lên cloud và lấy link ảnh về*/
            $result = $colud->uploadImage($request,'img',$request->title);
            $data["thumbnail"] = $result;
        }else {
            if (isset($request->thumbnail_link) && !is_null($request->thumbnail_link)) {
                /*tương tự với link*/
                $result = $colud->uploadImageByLink($request->thumbnail_link, $request->title);
                $data["thumbnail"] = $result;
            } else {
                /*trả về thông báo lỗi khi không có ảnh*/
                return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
            }
        }
        unset($data["thumbnail_link"]);
        $data["author_id"] = Auth::user()->id;
            /*tạo sản phẩm*/
            $result = $this->newRepository->createNew($data);
            return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    /**
     * Change status of new for soft delete.
     * @param Request $request
     * @return RedirectResponse
     */
    function changeStatus(Request $request): \Illuminate\Http\RedirectResponse
    {
        $result = $this->newRepository->updateNewById($request->id, ["status" => $request->status]);
        $messageSuccess = "Update product success!";
        $messageFail = "Update product fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    /**
     * Edit new.
     * @param Request $request
     * @return RedirectResponse
     */
    function editNew(Request $request)
    {
        $colud = new Cloundinary();
        $data = [
            "title" => $request->title,
            "description" => $request->description,
            "content" => $request->content,
            "status" => $request->status,
            "author_id" => Auth::user()->id,
        ];
        if (isset($request->img) && !is_null($request->img)) {
            /*tiến hành đẩy ảnh lên clound và lấy link ảnh mới về*/
            $result = $colud->uploadImage($request, 'img', $request->title . "news");
            $data["thumbnail"] = $result;
        } else {
            if (isset($request->thumbnail_link) && !is_null($request->thumbnail_link)) {
                /*kiểm tra xem người dùng có gửi link ảnh thay vì file không
                nếu có thì lấy link ảnh đẩy lên cloud và cập nhật lại sản phẩm*/
                $result = $colud->uploadImageByLink($request->thumbnail_link, $request->title);
                $data["thumbnail"] = $result;
            }
        }
        $result = $this->newRepository->updateNewById($request->id,$data);
        $messageSuccess = "Update product success!";
        $messageFail = "Update product fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }
}