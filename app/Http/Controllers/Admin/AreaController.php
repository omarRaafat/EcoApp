<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CountryStatus;
use Illuminate\Http\Request;
use App\Services\Admin\AreaService;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\AreaResource;
use App\Repositories\Admin\CountryRepository;
use App\Http\Requests\Admin\CreateAreaRequest;
use App\Http\Requests\Admin\UpdateAreaRequest;

class AreaController extends Controller
{
    /**
     * Product Class Controller Constructor.
     *
     * @param AreaService $service
     */
    public function __construct(
        public AreaService $service,
        public CountryRepository $countryRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $areas = $this->service->getAllAreasWithPagination($request);

        return view("admin.areas.index", compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $countries = $this->countryRepository->countriesMenu();
        $stateOfCountry = CountryStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.areas.index';
        $breadcrumbParentUrl = route('admin.areas.index');

        return view("admin.areas.create", compact("countries", "stateOfCountry", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAreaRequest  $request
     * @return Redirect
     */
    public function store(CreateAreaRequest $request)
    {
        $result = $this->service->createArea($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.areas.show", $result["id"]);
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
        $area = $this->service->getAreaUsingID($id);
        $breadcrumbParent = 'admin.areas.index';
        $breadcrumbParentUrl = route('admin.areas.index');
        $cities = $area->cities()->paginate(10);

        return view("admin.areas.show", compact(
            "area",
            "breadcrumbParent",
            "breadcrumbParentUrl",
            "cities",
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
        $area = $this->service->getAreaUsingID($id);
        $countries = $this->countryRepository->countriesMenu();
        $stateOfCountry = CountryStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.areas.index';
        $breadcrumbParentUrl = route('admin.areas.index');

        return view("admin.areas.edit", compact('area', 'countries', "stateOfCountry", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateAreaRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateAreaRequest $request, int $id)
    {
        $result = $this->service->updateArea($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.areas.show", $id);
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
        $result = $this->service->deleteArea($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.areas.index');
    }
}
