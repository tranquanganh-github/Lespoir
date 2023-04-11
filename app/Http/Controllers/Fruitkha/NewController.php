<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\NewRepository;
use App\Models\News;
use App\Http\Respone\NewRespone;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
        $news = News::select()->orderBy('created_at')->get();
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
        return view('client.new.single',compact('new'));
    }

    /**
     * Detail new (admin).
     * @param Request $request
     * @return Factory|View|Application
     */
    function createNewView(Request $request): Factory|View|Application
    {
        $new = News::find($request->id);
        return view('admin.form.new', compact('new'));
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
    function editNew(Request $request): RedirectResponse
    {
        $new = $this->newRepository->updateNewById($request->id, $request->all());
        $messageSuccess = "Update product success!";
        $messageFail = "Update product fail!";
        return $this->responeResultWithMessage($new, $messageSuccess, $messageFail);
    }
}