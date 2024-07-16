<?php

namespace App\Http\Controllers\Admin;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Events\Admin\Vendor\Modify;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Order;
use App\Enums\OrderStatus;

class VendorController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Vendor::with(['products', 'orders', 'VendorWarnings']);

        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Pipelines\Admin\Vendor\FilterApproval::class,
                \App\Pipelines\Admin\Vendor\FilterName::class,
                \App\Pipelines\Admin\Vendor\FilterRating::class,
                \App\Pipelines\Admin\Vendor\OrderCommission::class,
            ])
            ->thenReturn();
        $vendors = $query->orderBy('id', 'desc')->paginate(10);
        $warehouse = Warehouse::all()->first();
        return view('admin.vendor.index', ['vendors' => $vendors, 'warehouse' => $warehouse]);
    }

    public function show(Vendor $vendor)
    {
        $orders = Order::where('vendor_id' , $vendor->id)->where('status','!=',OrderStatus::WAITINGPAY)->latest()->paginate(50);
        $warehouses = Warehouse::where('vendor_id' , $vendor->id)->latest()->get();

        return view('admin.vendor.show', [
            'vendor' => $vendor,
            'orders' => $orders,
            'warehouses' => $warehouses,
            'breadcrumbParent' => 'admin.vendors.index',
            'breadcrumbParentUrl' => route('admin.vendors.index')
        ]);
    }

    public function edit(Vendor $vendor)
    {
        return view('admin.vendor.edit', [
            'vendor' => $vendor,
            'banks' => Bank::active()->when($vendor->bank, fn($q) => $q->where('id', '!=', $vendor->bank))->get(),
            'breadcrumbParent' => 'admin.vendors.index',
            'breadcrumbParentUrl' => route('admin.vendors.index')
        ]);
    }

    public function update(Vendor $vendor)
    {
        $vendor_attributes = request()->all();

        $vendor_attributes['is_international'] = (isset($vendor_attributes['is_international']) && $vendor_attributes['is_international'] == 'on') ? 1 : 0;

        if ($vendor_attributes['crd_hijry'] == "true") {
            if (preg_match('/^\d{4}[\/\-]((0?[1-6])[\/\-](0?[1-9]|[12][0-9]|3[01])|(0?[7-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|30))$/', $vendor_attributes['crd'])) {
                $dateChunks = explode("-", $vendor_attributes['crd']);
                $dateGerogrian = Hijri::DateToGregorianFromDMY($dateChunks[2], $dateChunks[1], $dateChunks[0]);
                $vendor_attributes['crd'] = \Carbon\Carbon::parse($dateGerogrian)->format('Y-m-d');
            }
        }


        $validator = Validator::make($vendor_attributes, [
            'name.*' => ['required', 'string', 'min:2', 'max:255'],
            'desc.*' => ['nullable', 'string', 'max:600'],
            'bank_num' => ['required', 'regex:/^[a-zA-Z0-9]+$/', 'min:10', 'max:16'],
            'tax_num' => ['required', function ($attribute, $value, $fail) {
                if (strlen($value) > 15 || strlen($value) < 15) {
                    $fail(trans("vendors.registration.validations.tax_num_size"));
                };
            }],
            'ipan' => ['required', 'min:20', 'max:30'],
            'name_in_bank' => ['required'],
            'commission' => ['required', 'numeric', 'gte:0'],
            'crd_hijry' => ['nullable'],
            'crd' => ['required', 'date_format:Y-m-d', 'after_or_equal:now'],
            'beez_id' => [
                Rule::unique('vendor_beez_configs', 'beez_id')->ignore($vendor->id, "vendor_id")
            ],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'iban_certificate' => ['nullable', 'mimes:pdf,png,jpg', 'max:2048'],
            'cr' => ['nullable', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'broc' => ['nullable', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'tax_certificate' => ['nullable', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'saudia_certificate' => ['nullable', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'subscription_certificate' => ['nullable', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'room_certificate' => ['nullable', 'file', 'mimes:pdf,png,jpg', 'max:2048'],

            'bank_id' => ["required", 'exists:banks,id'],
            'services' => ['required', 'array', 'min:1'],
        ], [
            "beez_id.unique" => trans("admin.beez_id_unique"),
            "second_phone.unique" => trans("vendors.registration.validations.second_phone_unique"),
            "name.ar" => trans("admin.vendors_info.validations.vendor_name_ar"),
            "name.en" => trans("admin.vendors_info.validations.vendor_name_en"),
            "commission.required" => trans("admin.vendors_info.validations.commission_required"),
            "commission.gte" => trans("admin.vendors_info.validations.commission_gte"),
            "second_phone.max" => trans("vendors.registration.validations.second_phone_max"),
            "second_phone.min" => trans("vendors.registration.validations.second_phone_min"),
            "website.url" => trans("vendors.registration.validations.website_url"),
            "street.required" => trans("vendors.registration.validations.street_required"),
            "store_name.required" => trans("vendors.registration.validations.store_name_required"),
            "store_name.string" => trans("vendors.registration.validations.street_string"),
            "store_name.max" => trans("vendors.registration.validations.street_max"),
            "desc.string" => trans("vendors.registration.validations.desc_string"),
            "logo.required" => trans("vendors.registration.validations.logo_required"),
            "logo.file" => trans("vendors.registration.validations.logo_image"),
            "logo.mimes" => trans("vendors.registration.validations.logo_mimes"),
            "logo.max" => trans("vendors.registration.validations.logo_max"),
            "tax_num.required" => trans("vendors.registration.validations.tax_num_required"),
            "cr.required" => trans("vendors.registration.validations.cr_required"),
            "cr.file" => trans("vendors.registration.validations.cr_file"),
            "cr.mimes" => trans("vendors.registration.validations.cr_mimes"),
            "cr.max" => trans("vendors.registration.validations.cr_max"),
            "iban_certificate.required" => trans("vendors.registration.validations.iban_certificate_required"),
            "iban_certificate.file" => trans("vendors.registration.validations.iban_certificate_file"),
            "iban_certificate.mimes" => trans("vendors.registration.validations.iban_certificate_mimes"),
            "iban_certificate.max" => trans("vendors.registration.validations.iban_certificate_max"),
            "crd.after" => trans("vendors.registration.validations.crd_after"),
            "broc.required" => trans("vendors.registration.validations.broc_required"),
            "broc.file" => trans("vendors.registration.validations.broc_file"),
            "broc.mimes" => trans("vendors.registration.validations.broc_mimes"),
            "broc.max" => trans("vendors.registration.validations.broc_max"),
            "tax_certificate.required" => trans("vendors.registration.validations.tax_certificate_required"),
            "tax_certificate.file" => trans("vendors.registration.validations.tax_certificate_file"),
            "tax_certificate.mimes" => trans("vendors.registration.validations.tax_certificate_mimes"),
            "tax_certificate.max" => trans("vendors.registration.validations.tax_certificate_max"),
            // "bank_name.required" => trans("vendors.registration.validations.bank_name_required"),
            "bank_id.required" => trans("vendors.registration.validations.bank_id_required"),
            "bank_num.required" => trans("vendors.registration.validations.bank_num_required"),
            "bank_num.max" => trans("vendors.registration.validations.bank_num_max"),
            "phone.unique" => trans("vendors.registration.validations.phone_unique"),
            "phone.max" => trans("vendors.registration.validations.phone_max"),
            "phone.min" => trans("vendors.registration.validations.phone_min"),
            "services.required" => trans("vendors.registration.validations.services_required"),
        ]);
        if ($validator->fails()) {
            session()->flash('warning',$validator->errors()->first());
            return back()->withInput();
        }

        $vendor_attributes['ipan'] = Str::contains($vendor_attributes['ipan'], "SA") ? $vendor_attributes['ipan'] : "SA{$vendor_attributes['ipan']}";

        $vendor->update($vendor_attributes);


        if (!empty(request()->beez_id)) {
            if ($vendor->beezConfig) {
                $vendor->beezConfig()->update(["beez_id" => request()->beez_id]);
            } else {
                $vendor->beezConfig()->create(["beez_id" => request()->beez_id]);
            }
        }

        event(new Modify($vendor));

        return redirect('admin/vendors');
    }

    public function approve(Vendor $vendor): \Illuminate\Http\JsonResponse
    {
        if ($vendor->approval == 'approved') {
            $vendor->approval = 'not_approved';
            $message = __('admin.vendor_not_approved');
        } else {
            $vendor->approval = 'approved';
            $message = __('admin.vendor_approved');
        }

        $vendor->save();
        return response()->json(['status' => 'success', 'data' => $vendor->approval, 'message' => $message], 200);
    }

    public function changeStatus(Vendor $vendor): \Illuminate\Http\JsonResponse
    {
        app()->setLocale("ar");
        if ($vendor->is_active == 1) {
            $vendor->is_active = 0;
            $message = __('admin.vendor_active_off');
        } else {
            $vendor->is_active = 1;
            $message = __('admin.vendor_active_on');
        }

        $vendor->save();
        return response()->json(['status' => 'success', 'data' => $vendor->is_active, 'message' => $message], 200);
    }

    public function accept_set_ratio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'ratio' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $Vendor = Vendor::where('id', $request->id)->first();
        if ($Vendor == null) {
            return response(['status' => false, 'message' => 'البائع غير متوفر']);
        }

        $Vendor->commission = intval($request->ratio);
        $Vendor->save();

        return response(['status' => true, 'message' => 'تمت تفعّيل بنجاح']);
    }

}
