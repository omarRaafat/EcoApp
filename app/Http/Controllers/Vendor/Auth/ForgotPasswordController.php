<?php

namespace App\Http\Controllers\Vendor\Auth;

use Illuminate\Http\Request;
use App\Services\Api\UserService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Services\NotificationCenterService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\App;
use App\Services\SendSms;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    const COUNTRY_CODE = "+966";

    public function __construct(public UserService $userService,public NotificationCenterService $notificationCenterService)
    {
        $this->userService = $userService;
        $this->notificationCenterService = $notificationCenterService;
    }

    public function showLinkRequestForm()
    {
        return view('vendor.auth.forget_password.forget_password');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = $this->validatePhone($request);

        if ($validator->fails()) {
            $request->merge(["phone" => explode(self::COUNTRY_CODE, $request->phone)[1]]);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::vendorUser()->where("phone", $request->get("phone"))->first();
        if (!$user) {
            return redirect()->back()->withErrors(__('translation.user_not_found'))->withInput();
        }

        $msg = $this->userService->_saveForgetPasswordCode($user->phone);
        SendSms::toSms($user->phone , $msg);

        return redirect('vendor/password/send-code')->with('phone', $request->phone);
    }

    /**
     * show page where vendor enter code to reset his password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function showResetPasswordForm(Request $request)
    {
        return view('vendor.auth.forget_password.send_code');
    }
    /**
     * send code then check it and redirect to chnage password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function confirmPhone(Request $request)
    {
        $request->validate(['code'=>'required','phone'=>'required']);
        $check=$this->userService->checkCode($request->code,$request->phone);
        if ($check) {
            return redirect('vendor/password/reset/'.$request->code.'?phone='.$request->phone);
        }
        return redirect()->back()->with('phone', $request->phone)->with('error',__('translation.wrong_code'));
    }
    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Validation\Validator
     */
    protected function validatePhone(Request $request) : \Illuminate\Validation\Validator
    {
        $request->merge([
            "phone" => self::COUNTRY_CODE . $request->phone
        ]);

        return Validator::make($request->all(), ['phone' => 'required|exists:users,phone']);
    }

}
