<?php

namespace App\Http\Controllers\Admin;

use App\Models\DomesticZone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Admin\TorodCompanyService;
use App\Http\Requests\Admin\CreateTorodCompanyRequest;
use App\Http\Requests\Admin\UpdateTorodCompanyRequest;

class TorodCompanyController extends Controller
{
    /**
     * Torod Company Controller Constructor.
     *
     * @param TorodCompanyService $service
     */
    public function __construct(public TorodCompanyService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request) : \Illuminate\Contracts\View\View
    {
        $torodCompanies = $this->service->getAllComapniesWithPagination($request);
        return view("admin.torodCompanies.index", compact('torodCompanies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : \Illuminate\Contracts\View\View
    {
        $breadcrumbParent = 'admin.torodCompanies.index';
        $breadcrumbParentUrl = route('admin.torodCompanies.index');
        $domisticZones = DomesticZone::get();
        return view("admin.torodCompanies.create", compact("breadcrumbParent", "breadcrumbParentUrl", "domisticZones"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTorodCompanyRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTorodCompanyRequest $request) : \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->createCompany($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.torodCompanies.show", $result["id"]);
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
        $torodCompany = $this->service->getCompanyUsingID($id);
        $breadcrumbParent = 'admin.torodCompanies.index';
        $breadcrumbParentUrl = route('admin.torodCompanies.index');

        return view("admin.torodCompanies.show", compact('torodCompany',  "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id) : \Illuminate\Contracts\View\View
    {
        $torodCompany = $this->service->getCompanyUsingID($id);
        $breadcrumbParent = 'admin.torodCompanies.index';
        $breadcrumbParentUrl = route('admin.torodCompanies.index');
        $domisticZones = DomesticZone::get();

        return view("admin.torodCompanies.edit", compact('torodCompany', "breadcrumbParent", "breadcrumbParentUrl", "domisticZones"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateTorodCompanyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTorodCompanyRequest $request, int $id) : \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->updateCompany($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.torodCompanies.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Torod Company Class Using ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id) : \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->deleteComapny($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.torodCompanies.index');
    }
}
