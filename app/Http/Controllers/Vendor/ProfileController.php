<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\UserTypes;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Services\Api\UserService;
use App\Services\Api\VendorService;
use App\Http\Controllers\Controller;
use App\Services\Admin\CountryService;
use App\Http\Requests\Vendor\UpdateProfileRequest;
use App\Http\Requests\Vendor\ChangePasswordRequest;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    const COUNTRY_CODE = "+966";

    public function __construct(UserService $userService,CountryService $countryService,VendorService $vendorService)
    {
        $this->userService=$userService;
        $this->countryService=$countryService;
        $this->vendorService=$vendorService;
    }

    public function show()
    {
        $data['row']=$this->userService->getUserUsingID(auth()->user()->id);
        return view('vendor.profile.show',$data);
    }

    public function edit()
    {
        $data['row']=$this->userService->getUserUsingID(auth()->user()->id);
        $data['countries']=$this->countryService->getAllCountries();
        $data["banks"] = Bank::where("is_active", true)->get();
        if($data['row']->vendor)
            $data['row']->vendor->crd=Carbon::parse($data['row']->vendor->crd)->toDateString();


        return view('vendor.profile.edit',$data);
    }

//    public function update(UpdateProfileRequest $request)
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "image" => "nullable|image|max:2048",

        ]);
        if($validator->fails())
            return back()->withErrors($validator);


 /*       $this->validate($request , [
            'name'=>'required|min:3',
            'phone'=>['required', 'min:10', 'regex:/^(05)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/' , function($attribute, $value, $fail) use($request){
                $request->merge(["phone" => self::COUNTRY_CODE . $request->phone]);
                $user = User::where("phone", $request->phone)->whereIn('type', [UserTypes::VENDOR, UserTypes::SUBVENDOR])->first();
                if($user && $user->id != auth()->user()->id) {
                    $request->merge([
                        "phone" => explode(self::COUNTRY_CODE, $request->phone)[1]
                    ]);
                    $fail(trans("vendors.registration.validations.phone_number_exists"));
                }
            }],
            'email'=> ['required', 'email',  function($attribute, $value, $fail) use ($request) {
                $user = User::where("email", $request->email)->whereIn('type', [UserTypes::VENDOR, UserTypes::SUBVENDOR])->first();
                if($user && $user->id != auth()->user()->id) {
                    $fail(trans("vendors.registration.validations.email_exists"));
                }
            }],
        ]);*/

        $user=auth()->user();
        $this->userService->updateUser($request,$user->id);
        session()->flash('success',__("vendors.successfully_updated"));
        return redirect()->back()->with('success',__('translation.profile_updated_successfully'));
    }

    public function updateVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "logo" => "nullable|image|max:2048",
            "cr" => "nullable|mimes:jpg,bmp,png,pdf|max:2048",
            'crd' => ['required', 'date', 'after_or_equal:now'],
            "iban_certificate" => "nullable|mimes:jpg,bmp,png,pdf|max:2048",
            "tax_certificate" => "nullable|mimes:jpg,bmp,png,pdf|max:2048",
            "saudia_certificate" => "nullable|mimes:jpg,bmp,png,pdf|max:2048",
            "subscription_certificate" => "nullable|mimes:jpg,bmp,png,pdf|max:2048",
            "room_certificate" => "nullable|mimes:jpg,bmp,png,pdf|max:2048",
            'ipan' => ['required', 'min:20', 'max:30'],
            'name_in_bank' => ['required'],
        ]);
        if ($validator->fails()) {
            session()->flash('warning',$validator->errors()->first());
            return back()->withInput();
        }


        $user=auth()->user();
        $request['ipan'] = 'SA'.ltrim(strtoupper($request->ipan),'SA');
        $this->vendorService->updateVendor($request,$user->vendor_id);
        session()->flash('success',__("vendors.successfully_updated"));
        return redirect()->back()->with(['success'=>__('translation.vendor_updated_successfully'),'id'=>'vendorData']);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user=auth()->user();
        $this->userService->updateUser($request,$user->id);
        session()->flash('success',__("vendors.successfully_updated"));
        return redirect()->back()->with(['success',__('translation.password_updated_successfully'),'id'=>'changePassword']);
    }
}
