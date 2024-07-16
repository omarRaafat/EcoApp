<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\StageLevels;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\StageResource;
use App\Http\Requests\Admin\CreateStageRequest;
use App\Http\Requests\Admin\CreatePreharvestStageRequest;
use App\Http\Requests\Admin\UpdatePreharvestStageRequest;
use App\Http\Requests\Admin\UpdateStageRequest;
use App\Http\Resources\Admin\PreharvestStageResource;
use App\Services\Admin\PreharvestStageService;
use Illuminate\Support\Facades\DB;

class PreharvestStageController extends Controller
{

    public function __construct(
        public PreharvestStageService $service,
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $stages = $this->service->getAllStagesWithPagination($request);

        return view("admin.preharvest-stages.index", compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $breadcrumbParent = 'admin.stages.index';
        $breadcrumbParentUrl = route('admin.stages.index');

        return view("admin.preharvest-stages.create", compact("breadcrumbParent", "breadcrumbParentUrl"));
    }

    public function store(CreatePreharvestStageRequest $request)
    {
        $result = $this->service->createStage($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.stages.index");
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
        $stage = $this->service->getStageUsingID($id);
        $breadcrumbParent = 'admin.stages.index';
        $breadcrumbParentUrl = route('admin.stages.index');

        return view("admin.preharvest-stages.show", compact(
            "stage",
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
        $stage = $this->service->getStageUsingID($id);
        $breadcrumbParent = 'admin.stages.index';
        $breadcrumbParentUrl = route('admin.stages.index');

        return view("admin.preharvest-stages.edit", compact('stage', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateStageRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdatePreharvestStageRequest $request, int $id)
    {
        $result = $this->service->updateStage($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.stages.index");
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
        $result = $this->service->deleteStage($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.stages.index');
    }
}
