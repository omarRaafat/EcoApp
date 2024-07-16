<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\Api\SearchService;

class SearchController extends ApiController
{
    public function __construct(
        private SearchService $service
    ) {}

    /**
     * @return JsonResponse
     */
    public function globalSearch() : JsonResponse {
        $parameter = request()->q ?? '';

        $response = $this->service->globalSearch($parameter);

        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
