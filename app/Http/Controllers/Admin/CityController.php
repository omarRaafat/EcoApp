<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CityStatus;
use Illuminate\Http\Request;
use App\Services\Admin\CityService;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\CityResource;
use App\Repositories\Admin\AreaRepository;
use App\Http\Requests\Admin\CreateCityRequest;
use App\Http\Requests\Admin\UpdateCityRequest;

class CityController extends Controller
{
    /**
     * Product Class Controller Constructor.
     *
     * @param CityService $service
     */
    public function __construct(
        public CityService $service,
        public AreaRepository $areaRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $cities = $this->service->getAllCitiesWithPagination($request);

        return view("admin.cities.index", compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $stateOfCity = CityStatus::getStatusListWithClass();
        $areas = $this->areaRepository->areasMenu();
        $breadcrumbParent = 'admin.cities.index';
        $breadcrumbParentUrl = route('admin.cities.index');

        return view("admin.cities.create", compact("stateOfCity", "areas", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCityRequest  $request
     * @return Redirect
     */
    public function store(CreateCityRequest $request)
    {
        $result = $this->service->createCity($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.cities.show", $result["id"]);
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
        $city = $this->service->getCityUsingID($id);
        $breadcrumbParent = 'admin.cities.index';
        $breadcrumbParentUrl = route('admin.cities.index');

        return view("admin.cities.show", compact('city', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $city = $this->service->getCityUsingID($id);
        $stateOfCity = CityStatus::getStatusListWithClass();
        $areas = $this->areaRepository->areasMenu();
        $breadcrumbParent = 'admin.cities.index';
        $breadcrumbParentUrl = route('admin.cities.index');

        return view("admin.cities.edit", compact('city', 'stateOfCity', 'areas', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateCityRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateCityRequest $request, int $id)
    {
        $result = $this->service->updateCity($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.cities.show", $id);
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
        $result = $this->service->deleteCity($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.cities.index');
    }
}
