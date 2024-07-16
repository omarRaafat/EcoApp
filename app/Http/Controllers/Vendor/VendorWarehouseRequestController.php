<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\CreateVendorWarehouseRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\VendorWarehouseRequestService;
use Exception;
use Illuminate\Support\Facades\DB;

class VendorWarehouseRequestController extends Controller
{
    public function __construct(public VendorWarehouseRequestService $service)
    {

        $this->view='vendor/warehouseRequests';
    }


    public function index(Request $request, int $perPage = 10,)
    {
        $vendorRequests = $this->service->getAllRequestsWithPagination($request, $perPage);
        return view($this->view.'/index',compact('vendorRequests'));

    }

    public function show(int $id,Request $request)
    {
        $vendorRequests = $this->service->getRequestWithProducts($id, $request);
        return view($this->view.'/show',compact('vendorRequests','id'));

    }

    public function showProducts(int $id,Request $request)
    {
        $vendorRequest = $this->service->getRequestsUsingID($id);
        return view($this->view.'/product-show',compact('vendorRequest','id'));

    }

    public function create()
    {
        $vendor = auth()->user()->vendor;
        return view($this->view.'/create' , compact('vendor'));
    }


    public function store(CreateVendorWarehouseRequest $request)
    {
        try {
            DB::beginTransaction();
            $result = $this->service->createRequest($request);
            if($result["success"] == true) {
                DB::commit();
                Alert::success($result["title"], $result["body"]);
                return redirect()->route("vendor.warhouse_request.show", $result["id"]);
            }
            DB::commit();
            Alert::error($result["title"], $result["body"]);
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error(__("vendors.create-warehouse-request-error"), $e->getMessage());
        }
        return redirect()->back();
    }
}
