<?php

namespace App\Services\Admin;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Repositories\RecipeRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Services\LogService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RecipeService
{
    /**
     * Recipe Service Constructor.
     *
     * @param RecipeRepository $repository
     */
    public function __construct(public RecipeRepository $repository
    ,public LogService $logger
    ) {

    }

    /**
     * Get Recipes.
     *
     * @return Collection
     */
    public function getAllRecipes() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Recipes with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllRecipesWithPagination($request, int $perPage = 10, string $orderBy = "desc") : LengthAwarePaginator
    {
        $Recipes = $this->repository
        ->all()
        ->newQuery();

        if($request->has("search")) {
                if($request->has("trans") && $request->trans != "all") {
                        $Recipes->where('title->' . $request->trans, 'LIKE', "%{$request->search}%");
                    }else{
                        $Recipes->where('title->ar', 'LIKE', "%{$request->search}%")
                        ->orwhere('title->en', 'LIKE', "%{$request->search}%");

                    }

                }


        return $Recipes->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Recipe using ID.
     *
     * @param integer $id
     * @return Recipe
     */
    public function getRecipeUsingID(int $id) : Recipe
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Recipe.
     *
     * @param Request $request
     * @return array
     */
    public function createRecipe(Request $request) : array
    {
        $request->merge([
            'most_visited'=> $request->most_visited == 'on'? 1:0,
            // 'image'=>'image/nologo.php'
        ]);

        $Recipe = $this->repository->store(
            $request->except('_method', '_token')
        );


        if(!empty($Recipe)) {
            $this->_createImage($Recipe, $request);
            $this->logger->InLog([
                'user_id' => auth()->user()->id,
                'action' => "CreateRecipe",
                'model_type' => "\App\Models\Recipe",
                'model_id' => $Recipe->id,
                'object_before' => null,
                'object_after' => $Recipe
            ]);
            return [
                "success" => true,
                "title" => trans("admin.recipes.messages.created_successfully_title"),
                "body" => trans("admin.recipes.messages.created_successfully_body"),
                "id" => $Recipe->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.recipes.messages.created_error_title"),
            "body" => trans("admin.recipes.messages.created_error_body"),
        ];
    }

    /**
     * Update Recipe Using ID.
     *
     * @param integer $Recipe_id
     * @param Request $request
     * @return array
     */
    public function updateRecipe(int $Recipe_id, Request $request) : array
    {
        $request->merge([
            'most_visited'=> $request->most_visited == 'on'? 1:0,
            // 'image'=>'image/nologo.php'
        ]);
        $Recipe = $this->getRecipeUsingID($Recipe_id);

        $oldRecipeObject = clone $Recipe;

        $this->repository->update($request->except('_method', '_token'), $Recipe);
        $this->_updateImage($Recipe, $request);


        $this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "UpdateRecipe",
            'model_type' => "\App\Models\Recipe",
            'model_id' => $Recipe_id,
            'object_before' => $oldRecipeObject,
            'object_after' => $Recipe
        ]);
        return [
            "success" => true,
            "title" => trans("admin.recipes.messages.updated_successfully_title"),
            "body" => trans("admin.recipes.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Recipe Using.
     *
     * @param int $Recipe_id
     * @return array
     */
    public function deleteRecipe(int $Recipe_id) : array
    {
        $Recipe = $this->getRecipeUsingID($Recipe_id);
        $this->_deleteOldCategoryImage($Recipe);
        $isDeleted = $this->repository->delete($Recipe);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.recipes.messages.deleted_successfully_title"),
                "body" => trans("admin.recipes.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.recipes.messages.deleted_error_title"),
            "body" => trans("admin.recipes.messages.deleted_error_message"),
        ];
    }


    private function _createImage(Recipe $recipe, Request $request) : void
    {
        if($request->has("image")) {
            $fileName = "image_" . time();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $recipe->addMediaFromRequest("image")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection("recipes");
        }
    }

    private function _updateImage(Recipe $recipe, Request $request) : void
    {
        if($request->has("image")) {
            $this->_deleteOldCategoryImage($recipe);
            $fileName = "image_" . time();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $recipe->addMediaFromRequest("image")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection("recipes");
        }
    }

    private function _deleteOldCategoryImage(Recipe $recipe) : void
    {
        $media = $recipe->media->first();

        if(!empty($media)) {
            $media->delete();
        }
    }
}
