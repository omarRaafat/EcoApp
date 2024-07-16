<?php
namespace App\Http\Controllers\Vendor\Auth;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Enums\UserTypes;
use App\Models\ShippingType;
use Config;
use App\Models\Bank;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    const COUNTRY_CODE = "+966";

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::VENDORLOGIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('vendor.guest');
    }

    public function showRegistrationForm()
    {
        $vendorTerms=Setting::where('key','vendor_terms')->first();

        $banks = Bank::where("is_active", true)->get();
        // $shipping_types = ShippingType::query()->get();
        return view('vendor.auth.register',get_defined_vars());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        request()->merge([
            "phone" => self::COUNTRY_CODE . request()->phone,
            "second_phone" => self::COUNTRY_CODE . request()->second_phone
        ]);

        if($data['crd_hijry'] == "true"){
            if(preg_match('/^\d{4}[\/\-]((0?[1-6])[\/\-](0?[1-9]|[12][0-9]|3[01])|(0?[7-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|30))$/',$data['crd'])){
            $dateChunks = explode("-", $data['crd']);
            $dateGerogrian = Hijri::DateToGregorianFromDMY($dateChunks[2],$dateChunks[1],$dateChunks[0]);
            $data['crd'] =\Carbon\Carbon::parse($dateGerogrian)->format('Y-m-d');
            }
         }

       return  $validateData= Validator::make($data, [
           'vendor_name' => ['required', 'string', 'max:255'],
            'store_name' => ['required', 'string', 'max:255'],
           'desc' => ['required', 'string', 'max:255'],


//           'phone'     => 'required|digits:10|starts_with:05|regex:/^[0-9]+$/',
            'phone' => ['required', 'digits:10','starts_with:05','regex:/^[0-9]+$/', function($attribute, $value, $fail) {
                $usersCount = User::where("phone", request()->phone)->where('type', UserTypes::VENDOR)->count();
                    if($usersCount > 0) {
                        $fail(trans("vendors.registration.validations.phone_number_exists"));
                    }
                }
            ],
            'second_phone' => [
                'required', 'digits:10','starts_with:05','regex:/^[0-9]+$/','different:phone', function($attribute, $value, $fail) {
                    $vendorsCount = Vendor::where("second_phone", request()->second_phone)->count();
                        if($vendorsCount > 0) {
                            $fail(trans("vendors.registration.validations.phone_number_exists"));
                        }
                    }
            ],
            'website' => ['nullable','min:6', 'max:191', 'url'],
            'email' => ['required', 'string', 'email', 'max:255', function($attribute, $value, $fail) {
                $usersCount = User::where("email", request()->email)->count();
                    if($usersCount > 0) {
                        $fail(trans("vendors.registration.validations.email_exists"));
                    }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
            // 'bank_num' => ['required','regex:/^[a-zA-Z0-9]+$/','min:10','max:16'],
            'tax_num' => ['required', function($attribute, $value, $fail) {
                if(strlen($value) > 15 || strlen($value) < 15) {
                    $fail(trans("vendors.registration.validations.tax_num_size"));
                };
            }],
             'ipan' => ['required','min:20','max:30'],
             'name_in_bank' => ['required','min:7'],
        //    'shipping_type' => ['required', 'array'],
            'crd_hijry' => ['nullable'],
            'crd' => ['required','date_format:Y-m-d','after_or_equal:now'],
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'iban_certificate' => ['required', 'mimes:pdf,png,jpg', 'max:2048'],
            'cr' => ['required', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
//            'broc' => ['nullable', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'tax_certificate' => ['required', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'saudia_certificate' => ['required', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'subscription_certificate' => ['required', 'file', 'mimes:pdf,png,jpg', 'max:2048'],
            'room_certificate' => ['required', 'file', 'mimes:pdf,png,jpg', 'max:2048'],

           //  'bank_name' => ['required'],
             'commercial_registration_no' => ["required","numeric"],
             'bank_id' => ["required"],
            'street' => ["required"],
           'desc' => ['required'],
           'services' => ['required', 'array', 'min:1'],
       ], [
//            "second_phone.unique" => trans("vendors.registration.validations.second_phone_unique"),
//            "second_phone.max" => trans("vendors.registration.validations.second_phone_max"),
//            "second_phone.min" => trans("vendors.registration.validations.second_phone_min"),
//            "second_phone.required" => trans("vendors.registration.validations.second_phone_required"),
//            "second_phone.regex" => trans("vendors.registration.validations.second_phone_regex"),

            "second_phone.different" => trans("vendors.registration.validations.second_phone_different"),

           "vendor_name.required" => trans("vendors.registration.validations.name_required"),

            "website.url" => trans("vendors.registration.validations.website_url"),
            "street.required" => trans("vendors.registration.validations.street_required"),
            "store_name.required" => trans("vendors.registration.validations.store_name_required"),
            "store_name.string" => trans("vendors.registration.validations.street_string"),
            "store_name.max" => trans("vendors.registration.validations.street_max"),
            "desc.string" => trans("vendors.registration.validations.desc_string"),
           "desc.required" => trans("vendors.registration.validations.desc_required"),

           "logo.required" => trans("vendors.registration.validations.logo_required"),
            "logo.file" => trans("vendors.registration.validations.logo_image"),
            "logo.mimes" => trans("vendors.registration.validations.logo_mimes"),
            "logo.max" => trans("vendors.registration.validations.logo_max"),
            "tax_num.required" => trans("vendors.registration.validations.tax_num_required"),
            "tax_num.regex" => trans("vendors.registration.validations.tax_num_regex"),
            "cr.required" => trans("vendors.registration.validations.cr_required"),
            "cr.file" => trans("vendors.registration.validations.cr_file"),
            "cr.mimes" => trans("vendors.registration.validations.cr_mimes"),
            "cr.max" => trans("vendors.registration.validations.cr_max"),
            "iban_certificate.required" => trans("vendors.registration.validations.iban_certificate_required"),
            "iban_certificate.file" => trans("vendors.registration.validations.iban_certificate_file"),
            "iban_certificate.mimes" => trans("vendors.registration.validations.iban_certificate_mimes"),
            "iban_certificate.max" => trans("vendors.registration.validations.iban_certificate_max"),
            "crd.after_or_equal" => trans("vendors.registration.validations.crd_after"),

            "crd.date_format" => trans("vendors.registration.validations.crd_date_format"),

            "broc.required" => trans("vendors.registration.validations.broc_required"),
            "broc.file" => trans("vendors.registration.validations.broc_file"),
            "broc.mimes" => trans("vendors.registration.validations.broc_mimes"),
            "broc.max" => trans("vendors.registration.validations.broc_max"),
            "tax_certificate.required" => trans("vendors.registration.validations.tax_certificate_required"),
            "tax_certificate.file" => trans("vendors.registration.validations.tax_certificate_file"),
            "tax_certificate.mimes" => trans("vendors.registration.validations.tax_certificate_mimes"),
            "tax_certificate.max" => trans("vendors.registration.validations.tax_certificate_max"),

           "saudia_certificate.required" => trans("vendors.registration.validations.saudia_certificate_required"),
           "saudia_certificate.file" => trans("vendors.registration.validations.saudia_certificate_file"),
           "saudia_certificate.mimes" => trans("vendors.registration.validations.saudia_certificate_mimes"),
           "saudia_certificate.max" => trans("vendors.registration.validations.sudai_certificate_max"),

           "subscription_certificate.required" => trans("vendors.registration.validations.subscription_certificate_required"),
           "subscription_certificate.file" => trans("vendors.registration.validations.subscription_certificate_file"),
           "subscription_certificate.mimes" => trans("vendors.registration.validations.subscription_certificate_mimes"),
           "subscription_certificate.max" => trans("vendors.registration.validations.subscription_certificate_max"),

           "room_certificate.required" => trans("vendors.registration.validations.room_certificate_required"),
           "room_certificate.file" => trans("vendors.registration.validations.room_certificate_file"),
           "room_certificate.mimes" => trans("vendors.registration.validations.room_certificate_mimes"),
           "room_certificate.max" => trans("vendors.registration.validations.room_certificate_max"),

            // "bank_name.required" => trans("vendors.registration.validations.bank_name_required"),
            "bank_id.required" => trans("vendors.registration.validations.bank_id_required"),
            "bank_num.required" => trans("vendors.registration.validations.bank_num_required"),
            "phone.unique" => trans("vendors.registration.validations.phone_unique"),
            "bank_num.max" => trans("vendors.registration.validations.bank_num_max"),
//            "phone.max" => trans("vendors.registration.validations.phone_max"),
//            "phone.min" => trans("vendors.registration.validations.phone_min"),
            "ipan.min" => trans("vendors.registration.validations.ipan_min"),
            "ipan.max" => trans("vendors.registration.validations.ipan_max"),
            "ipan.required" => trans("vendors.registration.validations.ipan_required"),
            "commercial_registration_no.required" => trans("vendors.registration.validations.commercial_registration_no_required"),
            "commercial_registration_no.numeric" => trans("vendors.registration.validations.commercial_registration_no_number"),
            "services.required" => trans("vendors.registration.validations.services_required"),
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if($data['crd_hijry'] == "true"){
            $dateChunks = explode("-", $data['crd']);
            $data['crd'] = Hijri::DateToGregorianFromDMY($dateChunks[2],$dateChunks[1],$dateChunks[0]);
         }

        $data['crd'] =\Carbon\Carbon::parse($data['crd'])->format('Y-m-d');
        $data['name'] = $data['vendor_name'];
        $user=User::create(['name'=>$data['name'],'email'=>$data['email'],'phone'=>$data['phone'],'password'=>$data['password'],'type'=> UserTypes::VENDOR]);
        $data['user_id']=$user->id;
        $data['name']=[ Config::get('app.locale') =>$data['store_name']];
        $data['desc']=[ Config::get('app.locale') =>$data['desc']];
        $data['ipan']=Str::contains($data['ipan'], "SA") ? $data['ipan'] : "SA{$data['ipan']}";
        $data['services'] = $data['services'];
        $vendor=Vendor::create($data);
        // $vendor->shippingTypes()->attach($data['shipping_type']);
        $vendor->wallet()->create(["balance" => 0]);
        $user->vendor_id=$vendor->id;
        $user->save();
        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        $request->name = $request['vendor_name'];
        if ($validator->fails()) {
            $request->merge([
                "phone" => explode(self::COUNTRY_CODE, $request->phone)[1],
                "second_phone" => explode(self::COUNTRY_CODE, $request->second_phone)[1]
            ]);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);
        session()->flash('success',__('translation.registration_done_message'));
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    protected function guard()
    {
        return auth();
    }
}
