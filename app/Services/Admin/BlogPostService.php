<?php

namespace App\Services\Admin;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Repositories\BlogPostRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Services\LogService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogPostService
{
    /**
     * BlogPost Service Constructor.
     *
     * @param BlogPostRepository $repository
     */
    public function __construct(public BlogPostRepository $repository
    ,public LogService $logger
    ) {

    }

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
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllBlogPostsWithPagination($request, int $perPage = 10, string $orderBy = "desc") : LengthAwarePaginator
    {
        $BlogPosts = $this->repository
        ->all()
        ->newQuery();

        if($request->has("search")) {
                if($request->has("trans") && $request->trans != "all") {
                        $BlogPosts->where('title->' . $request->trans, 'LIKE', "%{$request->search}%");
                    }else{
                        $BlogPosts->where('title->ar', 'LIKE', "%{$request->search}%")
                        ->orwhere('title->en', 'LIKE', "%{$request->search}%");

                    }

                }


        return $BlogPosts->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get BlogPost using ID.
     *
     * @param integer $id
     * @return BlogPost
     */
    public function getBlogPostUsingID(int $id) : BlogPost
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New BlogPost.
     *
     * @param Request $request
     * @return array
     */
    public function createBlogPost(Request $request) : array
    {
    
        $BlogPost = $this->repository->store(
            $request->except('_method', '_token')
        );


        if(!empty($BlogPost)) {
            $this->_createImage($BlogPost, $request);
            $this->logger->InLog([
                'user_id' => auth()->user()->id,
                'action' => "CreateBlogPost",
                'model_type' => "\App\Models\BlogPost",
                'model_id' => $BlogPost->id,
                'object_before' => null,
                'object_after' => $BlogPost
            ]);
            return [
                "success" => true,
                "title" => trans("admin.blogPosts.messages.created_successfully_title"),
                "body" => trans("admin.blogPosts.messages.created_successfully_body"),
                "id" => $BlogPost->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.blogPosts.messages.created_error_title"),
            "body" => trans("admin.blogPosts.messages.created_error_body"),
        ];
    }

    /**
     * Update BlogPost Using ID.
     *
     * @param integer $BlogPost_id
     * @param Request $request
     * @return array
     */
    public function updateBlogPost(int $BlogPost_id, Request $request) : array
    {
        // $request->merge([
        //     'most_visited'=> $request->most_visited == 'on'? 1:0,
        // ]);

        $BlogPost = $this->getBlogPostUsingID($BlogPost_id);

        $oldBlogPostObject = clone $BlogPost;

        $this->repository->update($request->except('_method', '_token'), $BlogPost);
        $this->_updateImage($BlogPost, $request);


        $this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "UpdateBlogPost",
            'model_type' => "\App\Models\BlogPost",
            'model_id' => $BlogPost_id,
            'object_before' => $oldBlogPostObject,
            'object_after' => $BlogPost
        ]);
        return [
            "success" => true,
            "title" => trans("admin.blogPosts.messages.updated_successfully_title"),
            "body" => trans("admin.blogPosts.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete BlogPost Using.
     *
     * @param int $BlogPost_id
     * @return array
     */
    public function deleteBlogPost(int $BlogPost_id) : array
    {
        $BlogPost = $this->getBlogPostUsingID($BlogPost_id);
        $this->_deleteOldCategoryImage($BlogPost);
        $isDeleted = $this->repository->delete($BlogPost);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.blogPosts.messages.deleted_successfully_title"),
                "body" => trans("admin.blogPosts.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.blogPosts.messages.deleted_error_title"),
            "body" => trans("admin.blogPosts.messages.deleted_error_message"),
        ];
    }


    private function _createImage(BlogPost $BlogPost, Request $request) : void
    {
        if($request->has("image")) {
            $fileName = "image_" . time();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $BlogPost->addMediaFromRequest("image")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection(BlogPost::mediaCollectionName);
        }
    }

    private function _updateImage(BlogPost $BlogPost, Request $request) : void
    {
        if($request->has("image")) {
            $this->_deleteOldCategoryImage($BlogPost);
            $fileName = "image_" . time();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $BlogPost->addMediaFromRequest("image")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection(BlogPost::mediaCollectionName);
        }
    }

    private function _deleteOldCategoryImage(BlogPost $BlogPost) : void
    {
        $media = $BlogPost->media->first();

        if(!empty($media)) {
            $media->delete();
        }
    }
}
