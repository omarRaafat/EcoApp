<?php

namespace App\Http\Controllers\Api;

use App\Models\BlogPost;
use App\Services\Api\BlogPostService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogPostController extends ApiController
{
    /**
     * BlogPost Controller Constructor.
     *
     * @param BlogPostService $service
     */
    public function __construct(public BlogPostService $service) {}

    /**
     * List all BlogPosts.
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        $response = $this->service->getAllBlogPostsinfityScroll();
        return $response;

    }    /**
     * List all BlogPosts.
     *
     * @return ResourceCollection
     */
    public function homePage() : ResourceCollection
    {
        return $this->service->homePage();

    }

    /**
     * Get BlogPost using id.
     *
     * @param id $BlogPost_id
     * @return JsonResponse
     */
    public function show(int $BlogPost_id) : JsonResponse
    {
        $response = $this->service->getBlogPostUsingID($BlogPost_id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
