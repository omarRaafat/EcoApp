<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Enums\AdminApprovedState;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Admin\ProductRateService;

class ProductRateController extends Controller
{
    /**
     * ProductRate Class Controller Constructor.
     *
     * @param ProductRateService $service
     */
    public function __construct(public ProductRateService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
      
        $productRates = $this->service->getAllProductRatesWithPagination($request);
        if(get_class($productRates) == "Symfony\Component\HttpFoundation\BinaryFileResponse") return $productRates;

        return view("admin.productRates.index", compact('productRates'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function show(int $id)
    {
        $productRate = $this->service->getProductRateUsingID($id)->load('user', 'admin');
        $breadcrumbParent = 'admin.productRates.index';
        $breadcrumbParentUrl = route('admin.productRates.index');
        return view("admin.productRates.show", compact('productRate', "breadcrumbParent", "breadcrumbParentUrl"));
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
        $result = $this->service->updateProductRate($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        }else{
            Alert::error($result["title"], $result["body"]);
        }

        
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
        $result = $this->service->deleteProductRate($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.productRates.index');
    }

    public function updateChecks(Request $request){
        $request->validate([
            'action' => 'required|in:2,3',
            'checks' => 'required|array',
        ]);

        $items = Review::whereIn('id',$request->checks)->update(['admin_approved' => $request->action]);

        session()->flash('success','تم التحديث بنجاح');
        return response()->json(['success'=>true]);    
    }
}