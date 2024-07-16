<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use App\Services\Api\RecipeService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipeController extends ApiController
{
    /**
     * Recipe Controller Constructor.
     *
     * @param RecipeService $service
     */
    public function __construct(public RecipeService $service) {}

    /**
     * List all Recipes.
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        $response = $this->service->getRecipesHomePage();
        return $response;
        
    }

    /**
     * Get Recipe using id.
     *
     * @param id $Recipe_id
     * @return JsonResponse
     */
    public function show(int $Recipe_id) : JsonResponse
    {
        $response = $this->service->getRecipeUsingID($Recipe_id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
