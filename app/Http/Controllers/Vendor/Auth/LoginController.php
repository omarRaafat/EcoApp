<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    const COUNTRY_CODE = "+966";

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::VENDORHOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('vendor.guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }

    //Overwrite
    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $request->merge(["phone" => self::COUNTRY_CODE . $request->phone]);

        if (auth()->attempt(['phone' => $request->phone, 'password' => $request->password, 'type' => ['vendor', 'sub-vendor']], $request->remember)) {
            $user = auth()->user();

            if ($user->is_banned == 1) {
                auth()->logout();
                $request->merge(["phone" => explode(self::COUNTRY_CODE, $request->phone)[1]]);
                return redirect( RouteServiceProvider::VENDORLOGIN )->withErrors([ 'warning' => __('translation.account_is_bannes') ]);
            }

            // Check User Type && Vendor Approval
            if (
                ($user->type == 'vendor' || $user->type == 'sub-vendor') &&
                $user->vendor->approval == 'approved' &&
                $user->vendor->is_active == 1
            ) {
                $request->merge(["phone" => explode(self::COUNTRY_CODE, $request->phone)[1]]);
                return redirect(RouteServiceProvider::VENDORHOME);
            } else {
                auth()->logout();
                $request->merge(["phone" => explode(self::COUNTRY_CODE, $request->phone)[1]]);
                return redirect(RouteServiceProvider::VENDORLOGIN)->withErrors(['warning'=>__('translation.approval_vendor_messaage')]);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        $request->merge([
            "phone" => explode(self::COUNTRY_CODE, $request->phone)[1]
        ]);
        return $this->sendFailedLoginResponse($request);
    }

    //Overwrite
    protected function guard()
    {
        return auth();
    }

    //Overwrite
    public function username()
    {
        return 'phone';
    }

    //Overwrite
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/vendor/login');
    }
}
