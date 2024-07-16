<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateQnaRequest;
use App\Services\Admin\QnaService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class QnaController extends Controller
{
    

    /**
     * @param QnaService $service
     */
    public function __construct(
        public QnaService $service,
    ) {}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $qnas = $this->service->getAllQnasWithPagination($request,20);
        return view("admin.qna.index",compact('qnas'));
    }
    
    public function create(){
        $breadcrumbParent = 'admin.qna.index';
        $breadcrumbParentUrl = route('admin.qna.index');
        
        return view('admin.qna.create', compact("breadcrumbParent", "breadcrumbParentUrl"));
    }

    public function store(CreateQnaRequest $request){

        $result = $this->service->createQna($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.qna.index");
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }


    public function edit(int $id)
    {
        $qna =  $this->service->getQnaUsingID($id);
        $breadcrumbParent = 'admin.qna.index';
        $breadcrumbParentUrl = route('admin.qna.index');

        return view("admin.qna.edit", compact('qna', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update the category..
     *
     * @param  UpdateCategoryRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(CreateQnaRequest $request, int $id)
    {
        $result = $this->service->updateQna($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.qna.index", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $result = $this->service->deleteQna($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.qna.index');
    }
}
