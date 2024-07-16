<?php

namespace App\Services\Api;

use App\Http\Resources\Api\RecipeResource;
use App\Models\Recipe;
use App\Models\Setting;
use App\Repositories\RecipeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;

class RecipeService
{
    /**
     * Recipe Service Constructor.
     *
     * @param RecipeRepository $repository
     */
    public function __construct(public RecipeRepository $repository) {}

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
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllRecipesWithPagination(int $perPage = 20)
    {
        $recipes = $this->repository->all()->paginate($perPage);
        $recipes->withPath("recipe");
        return RecipeResource::collection($recipes)->additional([
            "success" => true,
            "status" => 200,
            "message"=> trans("static_content.api.recipe.retrived")
        ]);
        
    }


    public function getRecipesHomePage(int $perPage = 10){
        
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;
       

        $recipes = $this->repository->all();
        $count = $recipes->count();

        $recipes = $recipes->offset($offset)->take($perPage)->get();
        $next = ($page * $perPage) < $count;

        $most_viewed = $this->repository->all()->where('most_visited', 1)->limit(4)->get();
        
        $settings = Setting::where('scope','global')->where('type','recipes')->get()->pluck('value','key')->toArray();
        
        return RecipeResource::collection($recipes)->additional([
            "success" => true,
            "status" => 200,
            'next' =>$next,
            'recipes_book' =>  $settings['recipes_book'],
            'recipes_page_desc' =>   (Config::get('app.locale')  == 'ar') ? $settings['recipes_page_desc']  : $settings['recipes_page_desc_en'],
            'recipes_page_title' =>  (Config ::get('app.locale') == 'ar') ? $settings['recipes_page_title'] : $settings['recipes_page_title_en'],
            'most_viewed' => RecipeResource::collection($most_viewed),
            "message"=> trans("static_content.api.recipe.retrived")
        ]);
    }

    

    /**
     * Get Recipe using ID.
     *
     * @param integer $id
     * @return Recipe
     */
    public function getRecipeUsingID(int $id) 
    {
        $recipe = $this->repository->getModelUsingID($id);
        if($recipe != null)
        {
            return [
                'success'=>true,
                'status'=>200 ,
                'data'=> new RecipeResource($recipe),
                'message'=>__('static_content.api.recipe.retrived')
            ];
        }
        return [
            'success'=>false,
            'status'=>404 ,
            'data'=> [],
            'message'=>__('static_content.api.recipe.not_found')
        ];
    }
}
