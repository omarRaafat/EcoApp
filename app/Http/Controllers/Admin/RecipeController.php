<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRecipeRequest;
use App\Services\Admin\RecipeService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class RecipeController extends Controller
{
    

    /**
     * @param RecipeService $service
     */
    public function __construct(
        public RecipeService $service,
    ) {}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $recipes = $this->service->getAllRecipesWithPagination($request,20);
        return view("admin.recipe.index",compact('recipes'));
    }

    public function show(int $id)
    {
        $recipe = $this->service->getRecipeUsingID($id);
        $breadcrumbParent = 'admin.recipe.index';
        $breadcrumbParentUrl = route('admin.recipe.index');
        return view("admin.recipe.show", compact('recipe', "breadcrumbParent", "breadcrumbParentUrl"));
    }
    
    public function create(){
        $breadcrumbParent = 'admin.recipe.index';
        $breadcrumbParentUrl = route('admin.recipe.index');

        return view('admin.recipe.create', compact("breadcrumbParent", "breadcrumbParentUrl"));
    }

    public function store(CreateRecipeRequest $request){

        $result = $this->service->createRecipe($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.recipe.index");
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }


    public function edit(int $id)
    {
        $recipe =  $this->service->getRecipeUsingID($id);
        $breadcrumbParent = 'admin.recipe.index';
        $breadcrumbParentUrl = route('admin.recipe.index');

        return view("admin.recipe.edit", compact('recipe', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update the category..
     *
     * @param  UpdateCategoryRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(CreateRecipeRequest $request, int $id)
    {
        $result = $this->service->updateRecipe($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.recipe.index", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $result = $this->service->deleteRecipe($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.recipe.index');
    }
}
