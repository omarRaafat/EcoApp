<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\PalmLengthLevels;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\PalmLengthResource;
use App\Http\Requests\Admin\CreatePalmLengthRequest;
use App\Http\Requests\Admin\CreatePreharvestPalmLengthRequest;
use App\Http\Requests\Admin\UpdatePreharvestPalmLengthRequest;
use App\Http\Requests\Admin\UpdatePalmLengthRequest;
use App\Http\Resources\Admin\PreharvestPalmLengthResource;
use App\Services\Admin\PalmLengthService;
use App\Services\Admin\PreharvestPalmLengthService;
use Illuminate\Support\Facades\DB;

class PalmLengthController extends Controller
{

    public function __construct(
        public PalmLengthService $service,
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $palm_lengths = $this->service->getAllPalmLengthsWithPagination($request);

        return view("admin.palm-lengths.index", compact('palm_lengths'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $breadcrumbParent = 'admin.palm-length.index';
        $breadcrumbParentUrl = route('admin.palm-lengths.index');

        return view("admin.palm-lengths.create", compact("breadcrumbParent", "breadcrumbParentUrl"));
    }

    public function store(CreatePalmLengthRequest $request)
    {
        $result = $this->service->createPalmLength($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.palm-lengths.index");
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function show(int $id)
    {
        $palm_length = $this->service->getPalmLengthUsingID($id);
        $breadcrumbParent = 'admin.palm-length.index';
        $breadcrumbParentUrl = route('admin.palm-lengths.index');

        return view("admin.palm-lengths.show", compact(
            "palm_length",
            "breadcrumbParent",
            "breadcrumbParentUrl",
        ));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $palm_length = $this->service->getPalmLengthUsingID($id);
        $breadcrumbParent = 'admin.palm-length.index';
        $breadcrumbParentUrl = route('admin.palm-lengths.index');

        return view("admin.palm-lengths.edit", compact('palm_length', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdatePalmLengthRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdatePalmLengthRequest $request, int $id)
    {
        $result = $this->service->updatePalmLength($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.palm-lengths.index");
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Product Class Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deletePalmLength($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.palm-lengths.index');
    }
}
