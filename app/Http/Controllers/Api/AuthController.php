<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Api\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\updateProfileRequest;
use App\Http\Requests\Api\CodeGenerationRequest;
use App\Http\Requests\Api\ApiRegistrationRequest;
use App\Http\Resources\Api\ProfileResource;

class AuthController extends ApiController
{
    public UserService $service;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
        $this->middleware('api.auth', ['except' => ['login','register', "generateCode"]]);
    }

    /**
     * Generate verification code for customer.
     *
     * @param CodeGenerationRequest $request
     * @return JsonResponse
     */
    public function generateCode(CodeGenerationRequest $request) : JsonResponse
    {
        $result = $this->service->checkIfPhoneNumberExists($request);

        return $this->setApiResponse(
            $result["isSuccess"],
            $result["statusCode"],
            $result["data"],
            $result["message"]
        );
    }

    /**
     * Authenticate the customer using phone number and verification code and return jwt.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request) : JsonResponse
    {
        $result = $this->service->logUserInUsingPhoneAndVerificatioCode($request);

        return $this->setApiResponse(
            $result["isSuccess"],
            $result["statusCode"],
            $result["data"],
            $result["message"]
        );
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return $this->setApiResponse(true,200,
        new ProfileResource(auth('api')->user()),
            __('customer.profile.retrived'));
    }


    /**
     * register the customer.
     *
     * @param  ApiRegistrationRequest $request
     * @return JsonResponse
     */
    public function register(ApiRegistrationRequest $request)
    {
        $user = $this->service->createUser($request);
        return $this->setApiResponse(true, 200, [],
        __('customer.register.success-register'));
    }

    /**
     * update the customer.
     *
     * @param  ApiRegistrationRequest $request
     * @return JsonResponse
     */
    public function updateProfile(updateProfileRequest $request)
    {
      //  $user = $this->service->updateUser($request,auth('api')->user()->id);
        return $this->setApiResponse(true, 200,
         new ProfileResource($user),
         __('customer.profile.updated'));
    }


    public function updateLanguage(string $lang)
    {
        $response = $this->service->updateLanguage($lang);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
        // return $this->setApiResponse();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return $this->setApiResponse(true,200,[],
        __('customer.login.success-logout'));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $access_token =  $this->service->refreshToken() ;
        return $this->setApiResponse(true,200,$access_token,
        '');
    }
}
