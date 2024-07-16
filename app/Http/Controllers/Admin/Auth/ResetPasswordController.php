<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMINHOME;

    public function showResetPasswordForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function submitResetPasswordForm(Request $request)
    {

       
       
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();
     
       
       

        if(!$updatePassword)
        {
            return "email or token is wrong";
           
            return back()->withInput()->with('error', 'Invalid token!');
        }

        try{
        $user = User::where('email',$request->get('email'))
        ->whereIn('type',['sub-admin','admin'])
        ->update(['password' => Hash::make($request->password)]);
        }catch(\Exception $e){
            return back()->withInput()->with('error', $e->getMessage());
        }


       

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect($this->redirectTo . '/login')->with('message', 'Your password has been changed!');
    }

}
