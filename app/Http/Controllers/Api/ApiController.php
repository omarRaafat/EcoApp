<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Set new api json response.
     *
     * @param boolean $isSuccess
     * @param integer $statusCode
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function setApiResponse(
        bool $isSuccess,
        int $statusCode,
        mixed $data,
        string $message = ""
    ) : JsonResponse {
        return new JsonResponse([
            "success" => $isSuccess,
            "status" => $statusCode,
            "data" => $data,
            "message" => $message,
        ], $statusCode);
    }
}
