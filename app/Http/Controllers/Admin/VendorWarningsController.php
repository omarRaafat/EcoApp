<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\Vendor\Warning;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorWarnings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorWarningsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Vendor $vendor)
    {
        //
        $vendorWarnings = VendorWarnings::where('vendor_id', $vendor->id)->get();
        return view('admin.vendor_warning.index',[
            'vendorWarnings' => $vendorWarnings,
            'vendor' => $vendor,
            'breadcrumbParent' => 'admin.vendors.index',
            'breadcrumbParentUrl' => route('admin.vendors.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'body' => ['required', 'string']
        ]);

        if ($validator->fails())
        {
            $key = $validator->errors()->first('body');
            return response()->json(['status' => 'failed','data' => [],'message' => $key,400]);
        }

        $vendorWarning = VendorWarnings::create([
            'vendor_id' => $request->vendor_id,
            'body' => $request->body
        ]);
        event(new Warning($vendorWarning));
        return response()->json(['status' => 'success','data' => $vendorWarning,'message' => __('admin.vendor_warning_send')],200);
    }
}
