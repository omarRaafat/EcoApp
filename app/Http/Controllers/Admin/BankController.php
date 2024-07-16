<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BankStatus;
use Illuminate\Http\Request;
use App\Services\Admin\BankService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\CreateBankRequest;
use App\Http\Requests\Admin\UpdateBankRequest;

class BankController extends Controller
{
    /**
     * Bank Controller Constructor.
     *
     * @param BankService $service
     */
    public function __construct(public BankService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request) : View
    {
        $banks = $this->service->getAllBanksWithPagination($request);
        
        return view("admin.banks.index", compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        $stateOfBank = BankStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.banks.index';
        $breadcrumbParentUrl = route('admin.banks.index');

        return view("admin.banks.create", compact("stateOfBank", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBankRequest  $request
     * @return RedirectResponse
     */
    public function store(CreateBankRequest $request) : RedirectResponse
    {
        $result = $this->service->createBank($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.banks.show", $result["id"]);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id) : View
    {
        $bank = $this->service->getBankUsingID($id);
        $breadcrumbParent = 'admin.banks.index';
        $breadcrumbParentUrl = route('admin.banks.index');

        return view("admin.banks.show", compact('bank', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id) : View
    {
        $bank = $this->service->getBankUsingID($id);
        $stateOfBank = BankStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.banks.index';
        $breadcrumbParentUrl = route('admin.banks.index');

        return view("admin.banks.edit", compact('bank', 'stateOfBank', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateBankRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(UpdateBankRequest $request, int $id) : RedirectResponse
    {
        $result = $this->service->updateBank($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.banks.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Bank Using ID.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(int $id) : RedirectResponse
    {
        $result = $this->service->deleteBank($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.banks.index');
    }
}