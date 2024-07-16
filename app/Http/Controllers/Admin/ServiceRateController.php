<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Enums\AdminApprovedState;
use App\Http\Controllers\Controller;
use App\Models\ServiceReview;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Admin\ServiceRateService;

class ServiceRateController extends Controller
{
    /**
     * ServiceRate Class Controller Constructor.
     *
     * @param ServiceRateService $service
     */
    public function __construct(public ServiceRateService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {

        $serviceRates = $this->service->getAllServiceRatesWithPagination($request);
        if(get_class($serviceRates) == "Symfony\Component\HttpFoundation\BinaryFileResponse") return $serviceRates;

        return view("admin.serviceRates.index", compact('serviceRates'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function show(int $id)
    {
        $serviceRate = $this->service->getServiceRateUsingID($id)->load('user', 'admin');
        $breadcrumbParent = 'admin.serviceRates.index';
        $breadcrumbParentUrl = route('admin.serviceRates.index');
        return view("admin.serviceRates.show", compact('serviceRate', "breadcrumbParent", "breadcrumbParentUrl"));
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
        $result = $this->service->updateServiceRate($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        }else{
            Alert::error($result["title"], $result["body"]);
        }


        return redirect()->back();
    }

    /**
     * Delete Service Class Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deleteServiceRate($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.serviceRates.index');
    }

    public function updateChecks(Request $request){
        $request->validate([
            'action' => 'required|in:2,3',
            'checks' => 'required|array',
        ]);

        $items = ServiceReview::whereIn('id',$request->checks)->update(['admin_approved' => $request->action]);

        session()->flash('success','تم التحديث بنجاح');
        return response()->json(['success'=>true]);
    }
}
