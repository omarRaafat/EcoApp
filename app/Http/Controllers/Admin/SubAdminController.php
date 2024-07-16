<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\SubAdminService;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\CreateSubAdminRequest;
use App\Http\Requests\Admin\UpdateSubAdminRequest;

class SubAdminController extends Controller
{
    /**
     * SubAdmin Controller Constructor.
     *
     * @param SubAdminService $service
     */
    public function __construct(public SubAdminService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request) : \Illuminate\Contracts\View\View
    {
        $subAdmins = $this->service->getAllSubAdminsWithPagination($request);
        return view("admin.subAdmins.index", compact('subAdmins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : \Illuminate\Contracts\View\View
    {
        $rules = Rule::subAdmin()->get();
        $breadcrumbParent = 'admin.subAdmins.index';
        $breadcrumbParentUrl = route('admin.subAdmins.index');

        return view("admin.subAdmins.create", compact("rules", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSubAdminRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSubAdminRequest $request) : \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->createSubAdmin($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.subAdmins.show", $result["id"]);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(int $id) : \Illuminate\Contracts\View\View
    {
        $subAdmin = $this->service->getSubAdminUsingID($id);
        $breadcrumbParent = 'admin.subAdmins.index';
        $breadcrumbParentUrl = route('admin.subAdmins.index');

        return view("admin.subAdmins.show", compact('subAdmin',  "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id) : \Illuminate\Contracts\View\View
    {
        $subAdmin = $this->service->getSubAdminUsingID($id);
        $rules = Rule::where("scope", "sub-admin")->get();
        $breadcrumbParent = 'admin.subAdmins.index';
        $breadcrumbParentUrl = route('admin.subAdmins.index');

        return view("admin.subAdmins.edit", compact('subAdmin', 'rules',  "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateSubAdminRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSubAdminRequest $request, int $id) : \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->updateSubAdmin($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.subAdmins.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete SubAdmin Class Using ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id) : \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->deleteSubAdmin($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.subAdmins.index');
    }
}