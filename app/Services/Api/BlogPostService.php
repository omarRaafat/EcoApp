<?php

namespace App\Services\Api;

use App\Http\Resources\Api\BlogPostResource;
use App\Models\BlogPost;
use App\Repositories\BlogPostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogPostService
{
    /**
     * BlogPost Service Constructor.
     *
     * @param BlogPostRepository $repository
     */
    public function __construct(public BlogPostRepository $repository) {}

    /**
     * Get BlogPosts.
     *
     * @return Collection
     */
    public function getAllBlogPosts() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get BlogPosts with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllBlogPostsinfityScroll(int $perPage = 10)
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;

        $BlogPosts = $this->repository->all();
        $count = $BlogPosts->count();

        $BlogPosts = $BlogPosts->offset($offset)->take($perPage)->get();
        $next = ($page * $perPage) < $count;

        return BlogPostResource::collection($BlogPosts)->additional([
            "success" => true,
            "status" => 200,
            'next' =>$next,
            "message"=> trans("static_content.api.BlogPost.retrived")
        ]);

    }    /**
     * Get BlogPosts with pagination.
     *
     * @param integer $perPage
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
 */
    public function homePage()
    {
        $BlogPosts = $this->repository->all()->take(7)->get();
        return BlogPostResource::collection($BlogPosts)->additional([
            "success" => true,
            "status" => 200,
            "message"=> trans("static_content.api.BlogPost.retrived")
        ]);

    }

    /**
     * Get BlogPost using ID.
     *
     * @param integer $id
     * @return BlogPost
     */
    public function getBlogPostUsingID(int $id)
    {
        $BlogPost = $this->repository->getModelUsingID($id);
        if($BlogPost != null)
        {
            return [
                'success'=>true,
                'status'=>200 ,
                'data'=> new BlogPostResource($BlogPost),
                'message'=>__('static_content.api.BlogPost.retrived')
            ];
        }
        return [
            'success'=>false,
            'status'=>404 ,
            'data'=> [],
            'message'=>__('static_content.api.BlogPost.not_found')
        ];
    }
}
