<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Api\VendorRepository;
use App\Services\Admin\VendorWarehouseRequestService;
use App\Http\Requests\Admin\CreateVendorWarehouseRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class VendorWarehouseRequestController extends Controller
{
    /**
     * VendorWarehouseRequest Controller Constructor.
     *
     * @param VendorWarehouseRequestService $service
     */
    public function __construct(
        public VendorWarehouseRequestService $service,
        public VendorRepository $vendorRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $vendorRequests = $this->service->getAllRequestsWithPagination($request);

        return view("admin.vendorRequests.index", compact('vendorRequests'));
    }


    public function show(int $id,Request $request)
    {
        $vendorRequests = $this->service->getRequestWithProducts($id,$request);
        $breadcrumbParent = 'admin.wareHouseRequests.index';
        $breadcrumbParentUrl = route('admin.wareHouseRequests.index');

        return view("admin.vendorRequests.show", compact('vendorRequests', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $vendors = Vendor::get();
        $breadcrumbParent = 'admin.wareHouseRequests.index';
        $breadcrumbParentUrl = route('admin.wareHouseRequests.index');
        return view("admin.vendorRequests.create", compact("vendors", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function createForVendor($vendorId)
    {
        $vendor = Vendor::with('products')->find($vendorId);
        $breadcrumbParent = 'admin.wareHouseRequests.index';
        $breadcrumbParentUrl = route('admin.wareHouseRequests.index');
        if ($vendor->products->isEmpty()) {
            Alert::error('', __('admin.wareHouseRequests.vendor-no-products'));
            return back();
        }
        return view("admin.vendorRequests.create-for-vendor", compact("vendor", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    public function store(CreateVendorWarehouseRequest $request)
    {
        try {
            DB::beginTransaction();
            $result = $this->service->createRequest($request);
            if($result["success"] == true) {
                DB::commit();
                Alert::success($result["title"], $result["body"]);
                return redirect()->route("admin.wareHouseRequests.show", $result["id"]);
            }
            DB::commit();
            Alert::error($result["title"], $result["body"]);
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error(__("admin.wareHouseRequests.messages.created_error_title"), $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function showProducts(int $id)
    {
        $vendorRequest = $this->service->getRequestsUsingID($id);
        $breadcrumbParent = 'admin.wareHouseRequests.index';
        $breadcrumbParentUrl = route('admin.wareHouseRequests.index');
        return view("admin.vendorRequests.product-show", compact('vendorRequest', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Delete vendor warehouse request Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deleteRequest($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.wareHouseRequests.index');
    }
}
