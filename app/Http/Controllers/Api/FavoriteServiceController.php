<?php
namespace App\Http\Controllers\Api;

use App\Services\Eportal\Connection;
use Illuminate\Http\JsonResponse;
use App\Services\Api\FavoriteServiceService;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FavoriteServiceController extends ApiController
{
    /**
     * Vendor Controller Constructor.
     *
     * @param VendorService $service
     */
    public function __construct(public FavoriteServiceService $service , Request $request)
    {

    }

    /**
     * List all vendors.
     *
     * @return JsonResponse
     */
    public function getFavorite() : JsonResponse
    {
        $response = $this->service->getFavoriteServices();
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    /**
     * Get Vendor using id.
     *
     * @param id $vendor_id
     * @return Response
     */
    public function addFavorite(Request $request) : JsonResponse
    {
        $response = $this->service->addFavoriteService($request->service_id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function deleteFavorite(int $id) : JsonResponse
    {
        $response = $this->service->deleteFavoriteService($id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
