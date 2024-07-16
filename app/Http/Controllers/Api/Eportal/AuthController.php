<?php

namespace App\Http\Controllers\Api\Eportal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Eportal\CheckIdentityRequest;
use App\Http\Requests\Api\Eportal\CodeVerifyRequest;
use App\Http\Requests\Api\Eportal\RegisterRequest;
use App\Models\Cart;
use App\Models\GuestCustomer;
use App\Traits\API\APIResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Eportal\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Str;
use Illuminate\Support\Facades\Session;
use App\Models\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\AuthorizationWallet;

class AuthController extends Controller
{
    use APIResponseTrait;

    /**
     * @param   CheckIdentityRequest $request
     * @return  JsonResponse
     */
    public function checkIdentity(Request $request): JsonResponse
    {
        try {
              $url =  config('eportal.sso_url'). 'common/oauth2/authorize?redirect_uri='. config('eportal.sso_callback');
              return response()->json(['redirect_url'=>$url]);
        } catch(Exception $ex){
            return $this->errorResponse($ex->getMessage() ,  $ex->getCode() == 0 ? 500 : $ex->getCode() );
        }
    }

    /**
     * @param   CheckIdentityRequest $request
     * @return  JsonResponse
     */
    /*
    public function resendkOTP(CheckIdentityRequest $request): JsonResponse
    {
        try{
            $eportalRoute = config('app.eportal_url')  . 'VerifyPhone_resend';
            return Connection::send($eportalRoute , ['identity' => $request->get('identity') ]);
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage() ,  $ex->getCode() == 0 ? 500 : $ex->getCode() );
        }

    }
    */

    /**
     * @param   RegisterRequest $request
     * @return  JsonResponse
     */
    /*
    public function register(RegisterRequest $request): JsonResponse
    {
        try{
            $eportalRoute = config('app.eportal_url')  . 'register';
            return Connection::send($eportalRoute , [
                'identity'  => $request->get('identity'),
                'phone'     => $request->get('phone'),
                'day'       => $request->get('day'),
                'month'     => $request->get('month'),
                'year'      => $request->get('year'),
            ]);
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage() ,  $ex->getCode() == 0 ? 500 : $ex->getCode() );
        }
    }


    /**
     * @param   Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try{
            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->successResponse(true , 'تم تسجيل الخروج');
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage() ,  $ex->getCode() == 0 ? 500 : $ex->getCode() );
        }
    }

    /**
     * @param   Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        try{
            return $this->successResponse(true, '', [
                'access_token' => auth('api_client')->user()->access_token,
                'token_type' => 'bearer',
                'user' => auth('api_client')->user()
            ]);
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage() ,  $ex->getCode() == 0 ? 500 : $ex->getCode() );
        }
    }

    public function createUser(Request $request) : JsonResponse
    {
        if($request->sso_secret != config('eportal.sso_secret')){
            return response()->json(['status'=>false],401);
        }

        $client = Client::updateOrInsert(
            [
                'identity' => $request->identity,
            ],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'birthDate' => $request->birthDate,
                'token' => $request->client_token
            ]
        );

        return response()->json(['status'=>true]);
    }

    public function UpdateUser(Request $request) : JsonResponse
    {
        if($request->sso_secret != config('eportal.sso_secret')){
            return response()->json(['status'=>false],401);
        }

        $client = Client::updateOrInsert(
            [
                'identity' => $request->identity,
            ],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'birthDate' => $request->birthDate,
            ]
        );

        return response()->json(['status'=>true]);
    }

    public function RemoveUser(Request $request) : JsonResponse
    {
        if($request->sso_secret != config('eportal.sso_secret')){
            return response()->json(['status'=>false],401);
        }

        $client = Client::where('identity',$request->identity)->delete();

        return response()->json(['status'=>true]);
    }

    public function getClientByToken(Request $request){
        try{
            $user = Client::with('authorizationWallet')->where('token','!=',null)->where('token' , $request->token)->latest()->first();
            if(!$user || empty($request->token)) return $this->errorResponse('فشل تسجيل الدخول' , 499 );

            auth()->guard('api_client')->login($user);
            $token = JWTAuth::fromUser($user);

            if(!is_null(request()->header('X-Guest-Token')) || request()->header('X-Guest-Token') != ""){
                $guestCustomer = GuestCustomer::where('token' , request()->header('X-Guest-Token'))->first();

                if($guestCustomer){
                    $userCart = Cart::where('user_id' , $user->id)->where('is_active' , 1)->first();
                    $guestCart = Cart::where('guest_customer_id' , $guestCustomer->id)->first();

                    if($guestCart){
                        DB::beginTransaction();
                        try {
                            #delete user old carts
                            foreach (Cart::where('user_id' , $user->id)->get() as $key => $cartItem) {
                                $cartItem->cartVendorShippings()->delete();
                                $cartItem->cartProducts()->delete();
                                $cartItem->delete();
                            }

                            #update user_id in guestCart
                            $guestCart?->update(['user_id' => $user->id , 'guest_customer_id' => null]);
                            $guestCart?->cartVendorShippings()?->update(['user_id' => $user->id , 'guest_customer_id' => null]);
                            $guestCustomer->delete();

                            DB::commit();
                        } catch (\Throwable $th) {
                            report($th);
                        }
                    }
                }

            }

            $user->update(['token'=>null]);

            return $this->successResponse(true ,'تم تسجيل الدخول بنجاح' , [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => auth('api_client')->user()
            ]);

        } catch(Exception $ex){
            DB::rollBack();
            if($ex->getCode() == 0)
                $statusCode = 500;
            elseif($ex->getCode() == 23000)
                $statusCode = 502;
            else
                $statusCode = $ex->getCode();
            return $this->errorResponse($ex->getMessage() ,  $statusCode );
        }
    }

    public function authorizationWallet(Request $request){
        try {
            $user =auth()->guard('api_client')->user();
            AuthorizationWallet::firstOrCreate([
                'client_id'=> $user->id
            ]);
            $user = Client::with('authorizationWallet')->find($user->id);
            return $this->successResponse(true ,'تم موافقة بنجاح' , [
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            report($th);
        }
    }
}
