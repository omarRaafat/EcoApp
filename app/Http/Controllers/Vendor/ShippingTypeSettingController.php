<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\ShippingType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class ShippingTypeSettingController extends Controller
{
    /**
     * @return View
     */
    public function edit(): View
    {
        $shipping_types = ShippingType::query()->get();
        return view('vendor.settings.edit_shipping' , get_defined_vars());
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request , [
           'shipping_type'  => 'required|array',
        ]);

        $vendor = auth()->user()->vendor;
        $vendor->shippingTypes()->sync($request->shipping_type);
        Alert::success(__("admin.categories.messages.updated_successfully_title"), __("admin.categories.messages.updated_successfully_body"));
        return back();
    }
}
