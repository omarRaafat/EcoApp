<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CetegoryService
{
    /**
     * Category Service Constructor.
     *
     * @param CategoryRepository $repository
     * @param LogService $logger
     */
    public function __construct(
        public CategoryRepository $repository,
        public LogService $logger
    ) {}

    /**
     * Get Categories.
     *
     * @return Collection
     */
    public function getAllCategories() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Categories with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllMainCategoriesWithPagination(Request $request, int $perPage = 10, string $orderBy = "ASC") : LengthAwarePaginator
    {
        $categories = $this->repository->all()->where("level", 1)->where("parent_id", null)->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $categories->where('name->' . $request->trans, 'LIKE', "%{$request->input('search')}%");
            }
        }

        if ($request->has('is_active') && $request->get('is_active') != "all") {

            $categories->where("is_active", "=", $request->get('is_active'));
        }

        return $categories->orderBy("order", $orderBy)->paginate($perPage);
    }

    /**
     * Get SubCategories with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllSubCategoriesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $categories = $this->repository->all()->where("level", 2)->where("parent_id", "!=", null)->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $categories->where('name->' . $request->trans, 'LIKE', "%{$request->input('search')}%");
            }
        }

        if ($request->has('is_active')) {
            $categories->where("is_active", "=", $request->is_active);
        }

        return $categories->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get SubChildCategories with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllSubChildCategoriesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $categories = $this->repository->all()->where("level", 2)->where("parent_id", "!=", null)->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $categories->where('name->' . $request->trans, 'LIKE', "%{$request->input('search')}%");
            }
        }

        if ($request->has('is_active')) {
            $categories->where("is_active", "=", $request->is_active);
        }

        return $categories->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Category using ID.
     *
     * @param integer $id
     * @return Category
     */
    public function getCategoryUsingID(int $id) : Category
    {
        return $this->repository
                    ->all()
                    ->with(["child"])
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Category.
     *
     * @param Request $request
     * @return array
     */
    public function createCategory(Request $request) : array
    {
        $slug=[];

        foreach($request->name as $key => $nameLang){
            $slug[$key] = Str::slug($nameLang, '-');
        }

        $request->merge(['slug'=>$slug]);

        $category = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($category)) {
            $this->_createImage($category, $request);
            $this->logger->InLog([
                'user_id' => auth()->user()->id,
                'action' => "CreateCategory",
                'model_type' => "\App\Models\Category",
                'model_id' => $category->id,
                'object_before' => null,
                'object_after' => $category
            ]);

            return [
                "success" => true,
                "title" => trans("admin.categories.messages.created_successfully_title"),
                "body" => trans("admin.categories.messages.created_successfully_body"),
                "data" => $category
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.categories.messages.created_error_title"),
            "body" => trans("admin.categories.messages.created_error_body"),
        ];
    }

    /**
     * Update Category.
     *
     * @param integer $category_id
     * @param Request $request
     * @return array
     */
    public function updateCategory(int $category_id, Request $request) : array
    {
        $slug=[];

        foreach($request->name as $key => $nameLang){
            $slug[$key] = Str::slug($nameLang, '-');
        }

        $request->merge(['slug'=>$slug]);

        $category = $this->getcategoryUsingID($category_id);
        $oldCategoryObject = clone $category;
        
        $isUpdated = $this->repository->update($request->except('_method', '_token'), $category);

        $this->_updateImage($category, $request);

        $this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "UpdateCategory",
            'model_type' => "\App\Models\Category",
            'model_id' => $category_id,
            'object_before' => $oldCategoryObject,
            'object_after' => $category
        ]);

        return [
            "success" => true,
            "title" => trans("admin.categories.messages.updated_successfully_title"),
            "body" => trans("admin.categories.messages.updated_successfully_body"),
            "data" => $category
        ];
    }

    /**
     * Delete Category.
     *
     * @param int $category_id
     * @return array
     */
    public function deleteCategory(int $category_id) : array
    {
        $falseBody = trans("admin.categories.messages.deleted_error_message");
        $category = $this->getCategoryUsingID($category_id);
        if ($category->hasProducts()) {
            $isDeleted = false;
            $falseBody = trans("admin.cant-delete-related-to-product");
        } else {
            $oldCategoryObject = clone $category;
            $isDeleted = $this->repository->delete($category);
        }
        if($isDeleted == true) {
            $this->logger->InLog([
                'user_id' => auth()->user()->id,
                'action' => "DeleteCategory",
                'model_type' => "\App\Models\Category",
                'model_id' => $category->id,
                'object_before' => $oldCategoryObject,
                'object_after' => $category
            ]);

            return [
                "success" => true,
                "title" => trans("admin.categories.messages.deleted_successfully_title"),
                "body" => trans("admin.categories.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.categories.messages.deleted_error_title"),
            "body" => $falseBody,
        ];
    }

    /**
     * Create new image using spatie medialibrary and assossiate it to category.
     *
     * @param Category $category
     * @param Request $request
     * @return void
     */
    private function _createImage(Category $category, Request $request) : void
    {
        if($request->has("image") && $request->image != '')
        {
            $fileName = "image_" . time();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $category->addMediaFromRequest("image")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection("categories");
        }
    }

    /**
     * Update Category image using spatie medialibrary and assossiate it to category.
     *
     * @param Category $category
     * @param Request $request
     * @return void
     */
    private function _updateImage(Category $category, Request $request) : void
    {
        if($request->has("image")) {
            $this->_deleteOldCategoryImage($category);
            $fileName = "image_" . time();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $category->addMediaFromRequest("image")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection("categories");
        }
    }

    /**
     * Delete old image media from spatie media collections.
     *
     * @param Category $category
     * @return void
     */
    private function _deleteOldCategoryImage(Category $category) : void
    {
        $media = $category->media->first();

        if(!empty($media)) {
            $media->delete();
        }
    }
}
