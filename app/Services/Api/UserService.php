<?php

namespace App\Services\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\WalletService;
use App\Repositories\Api\UserRepository;
use App\Http\Resources\Api\ProfileResource;
use App\Services\NotificationCenterService;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Api\ApiRegistrationRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * User Service Constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(public UserRepository $repository,
    public NotificationCenterService $notificationService,
    public WalletService $walletService) {}

    /**
     * Get User.
     *
     * @return Collection
     */
    public function getAllUsers() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get User with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllUsersWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->paginate($perPage);
    }

    /**
     * Get User using ID.
     *
     * @param integer $id
     * @return User
     */
    public function getUserUsingID(int $id) : User
    {
        return $this->repository->getModelUsingID($id);
    }
    /**
     * Get User using ID.
     *
     * @param string $phone
     * @return User
     */
    public function getUserUsingPhone(string $phone, string $userType)
    {
        return $this->repository->getModelUsingPhone($phone, $userType);
    }

    public function createUser(ApiRegistrationRequest $request)
    {

        $request->merge(['type' => 'customer',
                        'name'=>$request->first_name .' '. $request->last_name]);

        $user = $this->repository->store($request->toArray());

        $request->merge([
            'customer_id'=> $user->id,
            'is_active' =>1,
            'amount'    =>0,
            'reason'    =>''
        ]);

        $this->walletService->createWallet($request);
        return $user;
    }

    public function updateUser(Request $request ,$id = null)
    {
        $request = $request->all();
        if($id == null)
            $id = auth('api')->user()->id;
        $user = $this->getUserUsingID($id);
        $user = $this->repository->update($request,$user);
        return $user;
    }

    public function updateLanguage($lang){

        if(! in_array($lang , ['ar','en']) )
        {
            return  ['success'=>false, 'status'=>404 ,
            'data'=>[],
            'message'=>__('customer.lang_not_found')];
        }
        $user = auth('api')->user();
        $user = $this->repository->update(['lang'=>$lang],$user);
        App::setLocale($lang);
        return  [
            'success'=>true,
            'status'=>200 ,
            'data'=>new ProfileResource($user),
            'message'=>__('customer.language.updated')];

    }

    public function refreshToken(){

        return $this->getAccessToken( auth('api')->refresh() );

    }

    protected function getAccessToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }

    protected function guard() : Guard
    {
        return Auth::guard('api');
    }

    /**
     * Check if the phone mumber exists than sent code via sms.
     *
     * @param Request $request
     * @return array
     */
    public function checkIfPhoneNumberExists(Request $request) : array
    {
        $user = $this->repository->all()->phone($request->phone)->customerUser()->first();


        if(!empty($user)) {
             if($user->is_banned == 1){
            return [
                "isSuccess" => false,
                "statusCode" => 403,
                "data" => [],
                "message" => trans("customer.login.user_is_banned")
            ];
        }

            $code = App::isProduction() ? rand(1000, 9999) : 1234;

            $this->_updateUserVerificationFieldsOnGenerate($user, $code);

            if(App::isProduction()) {
                $this->notificationService->toSms([
                    "user" => $user,
                    "message" => trans("customer.login.your_verification_code_is") . $code
                ]);
                $data=[$request->phone];
            }else{
                $data=[$request->phone,$code];
            }

            return [
                "isSuccess" => true,
                "statusCode" => 200,
                "data" => $data, //@todo Change-Code
                "message" => trans("customer.login.phone_found_message")
            ];
        }

        return [
            "isSuccess" => false,
            "statusCode" => 404,
            "data" => null,
            "message" => trans("customer.login.phone_not_found_message")
        ];
    }

    /**
     * Log the user in the system using phone number and verification code.
     *
     * @param Request $request
     * @return array
     */
    public function logUserInUsingPhoneAndVerificatioCode(Request $request) : array
    {
        $user = $this->repository->all()->phone($request->phone)->customerUser()->where("verification_code", $request->code)->where('is_banned',0)->first();
        if(
            !$user ||
            ($user && is_null($user->verification_code_expiration_date)) ||
            ($user && Carbon::parse($user->verification_code_expiration_date) < now())
        ) {
            return [
                "isSuccess" => false,
                "statusCode" => 400,
                "data" => null,
                "message" => trans("customer.login.fail-login")
            ];
        }
        $user->ip = $request->ip();
        $this->_updateUserVerificationFieldsOnLogin($user);
        // Uncomment this to set local from user language
        // App::setLocale($user->lang);

        return [
            "isSuccess" => true,
            "statusCode" => 200,
            "data" => [
                "user" => new ProfileResource($user),
                "token" => $this->guard()->login($user)
            ],
            "message" => trans("customer.login.success-login",['user' => $user->name])
        ];
    }

    /**
     * Update verifaction fields on generate verification code action.
     *
     * @param User $user
     * @param integer $code
     * @return void
     */
    private function _updateUserVerificationFieldsOnGenerate(User $user, int $code) : void
    {
        $this->repository->update([
            "verification_code" => $code,
            "verification_code_expiration_date" => Carbon::now()->addMinutes(30)->toDateTimeString()
        ], $user);
    }

    /**
     * Update verifaction fields on login code action.
     *
     * @param User $user
     * @return void
     */
    private function _updateUserVerificationFieldsOnLogin(User $user) : void
    {
        $this->repository->update([
            "verification_code" => null,
            "verification_code_expiration_date" => null,
            'ip' =>$user->ip
        ], $user);
    }

    public function _saveForgetPasswordCode($phone) : string
    {
        $code = App::isProduction() ? generateRandomString(5) : 1234;

        DB::table('password_resets')->where('phone', $phone)->delete();
        DB::table('password_resets')->insert(['phone' => $phone, 'token' => $code]);
        return __('translation.your_reset_password_code_is') . ": $code";
    }

    private function checkPhoneToken($code,$phone)
    {
        return DB::table('password_resets')->where('phone',$phone)->where('token',$code);
    }

    public function checkCode($code,$phone)
    {
        $query=$this->checkPhoneToken($code,$phone);
        $checkToken=$query->first();
        if ($checkToken) {
            return true;
        }
        return false;
    }

    public function resetPassword($request, string $userType) : bool
    {
        $query=$this->checkPhoneToken($request->token,$request->phone);
        $checkToken=$query->first();
        $user=$this->getUserUsingPhone($request->phone, $userType);
        if ($checkToken) {
            $user=$this->repository->update(['password'=>$request->password],$user);
            $query->delete();
            auth()->login($user);
            return true;
        }
        return false;
    }
}
