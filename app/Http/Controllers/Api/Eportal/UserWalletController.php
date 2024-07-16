<?php

namespace App\Http\Controllers\Api\Eportal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Eportal\CheckIdentityRequest;
use App\Http\Requests\Api\Eportal\CodeVerifyRequest;
use App\Http\Requests\Api\Eportal\RegisterRequest;
use App\Traits\API\APIResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Eportal\Connection;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use App\Enums\SettingEnum;

class UserWalletController extends Controller
{

    /**
     * @param   Request $request
     * @return JsonResponse
     */
    public function getMyWallets(): JsonResponse
    {
        try{
            return Connection::userAuthWallet(request())?->json()['data'] ?? [];
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage() ,  $ex->getCode() == 0 ? 500 : $ex->getCode() );
        }
    }


    public function WalletSecretKey(Request $request){
        if($request->sso_secret != config('eportal.sso_secret') || empty($request->encrypted) || intval(date('H')) != 4){
            return response()->json(['status'=>false],401);
        }
        
        try {
            $done = Setting::updateOrInsert(
                [ 
                    'key' => SettingEnum::secret_wallet_key,
                ],
                [
                    'value' => $request->encrypted,
                ]
            );
            
            if($done){
                return response()->json(['status'=>true]);
            }
            return response()->json(['status'=>false,'message'=>json_encode($done)],400);

        } catch (\Throwable $th) {
            report($th);
        }

    }
}
