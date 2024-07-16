<?php

namespace App\Http\Controllers\Api;

use App\Models\StaticContent;
use App\Services\Api\StaticContentService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StaticContentController extends ApiController
{
    /**
     * StaticContent Controller Constructor.
     *
     * @param StaticContentService $service
     */
    public function __construct(public StaticContentService $service) {}

    /**
     * List all StaticContents.
     *
     * @return ResourceCollection
     */
    public function index(string $type) : ResourceCollection
    {
        $response = $this->service->getAllStaticContents($type);
        return $response;
        
    }

    
}
