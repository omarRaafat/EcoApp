<?php

namespace App\Traits\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait APIResponseTrait
{
    /**
     * @param   boolean         $status
     * @param   string|null     $message
     * @param   array           $data
     * @param   int             $statusCode
     * @return  JsonResponse
     */
    public function successResponse(bool $status = true , string $message = null , array $data = []  , int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data'    => $data
        ], $statusCode);
    }



    /**
     * @param  string|null  $message
     * @param  int          $statusCode
     * @return JsonResponse
     */
    public function errorResponse(string $message = null, int $statusCode = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
}
