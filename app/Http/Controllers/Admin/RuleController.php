<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Services\Admin\RuleService;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\RuleResource;
use App\Http\Requests\Admin\CreateRuleRequest;
use App\Http\Requests\Admin\UpdateRuleRequest;

class RuleController extends Controller
{
    /**
     * Rule Class Controller Constructor.
     *
     * @param RuleService $service
     */
    public function __construct(public RuleService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request) : \Illuminate\Contracts\View\View
    {
        $rules = $this->service->getAllRulesWithPagination($request);
        return view("admin.rules.index", compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : \Illuminate\Contracts\View\View
    {
        $allPermissions = Permission::where("scope", "sub-admin")->get();
        $permissions = $allPermissions->groupBy("module");
        $breadcrumbParent = 'admin.rules.index';
        $breadcrumbParentUrl = route('admin.rules.index');

        return view("admin.rules.create", compact("permissions", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRuleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRuleRequest $request) : \Illuminate\Http\RedirectResponse
    {
        // dd($request->all());
        $result = $this->service->createRule($request);
        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.rules.show", $result["id"]);
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
        $rule = $this->service->getRuleUsingID($id);
        $allPermissions = $rule->permissions()->where("scope", "sub-admin")->get();
        $permissions = $allPermissions->groupBy("module");
        $breadcrumbParent = 'admin.rules.index';
        $breadcrumbParentUrl = route('admin.rules.index');

        return view("admin.rules.show", compact('rule', 'permissions', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id) : \Illuminate\Contracts\View\View
    {

        $allPermissions = Permission::where("scope", "sub-admin")->get();
        $permissions = $allPermissions->groupBy("module");
        $rule = $this->service->getRuleUsingID($id);
        $breadcrumbParent = 'admin.rules.index';
        $breadcrumbParentUrl = route('admin.rules.index');

        return view("admin.rules.edit", compact('rule', 'permissions', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateRuleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRuleRequest $request, int $id) : \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->updateRule($id, $request);
        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.rules.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Rule Class Using ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id) : \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->deleteRule($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.rules.index');
    }
}