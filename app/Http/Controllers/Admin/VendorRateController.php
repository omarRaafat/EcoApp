<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\VendorRateService;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\UserVendorRate;

class VendorRateController extends Controller
{
    /**
     * VendorRate Class Controller Constructor.
     *
     * @param VendorRateService $service
     */
    public function __construct(public VendorRateService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $vendorRates = $this->service->getAllVendorRatesWithPagination($request);
        if(get_class($vendorRates) == "Symfony\Component\HttpFoundation\BinaryFileResponse") return $vendorRates;

        return view("admin.vendorRates.index", compact('vendorRates'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function show(int $id)
    {
        $vendorRate = $this->service->getVendorRateUsingID($id)->load('vendor', 'customer', 'admin');
        $breadcrumbParent = 'admin.vendorRates.index';
        $breadcrumbParentUrl = route('admin.vendorRates.index');
        return view("admin.vendorRates.show", compact('vendorRate', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(Request $request, int $id)
    {
        $result = $this->service->updateVendorRate($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        }else{
            Alert::error($result["title"], $result["body"]);
        }

        
        return redirect()->back();
    }

    /**
     * Delete Vendor Rate Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deleteVendorRate($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.vendorRates.index');
    }

    public function updateChecks(Request $request){
        $request->validate([
            'action' => 'required|in:2,3',
            'checks' => 'required|array',
        ]);

        $items = UserVendorRate::whereIn('id',$request->checks)->update(['admin_approved' => $request->action]);

        session()->flash('success','تم التحديث بنجاح');
        return response()->json(['success'=>true]);    
    }
}