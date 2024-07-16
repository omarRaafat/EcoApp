<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\CategoryLevels;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\CreatePreharvestCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Requests\Admin\UpdatePreharvestCategoryRequest;
use App\Services\Admin\PreharvestCategoryService;
use Illuminate\Support\Facades\DB;

class PreharvestCategoryController extends Controller
{

    public function __construct(
        public PreharvestCategoryService $service,
    ) {}


    public function index(Request $request)
    {
        $categories = CategoryResource::collection(
            $this->service->getAllMainCategoriesWithPagination($request)
        );

        return view("admin.preharvest-categories.index", compact('categories'));
    }

    public function create()
    {
        return view("admin.preharvest-categories.create",['level' => 1]);
    }

    public function createSubCategory()
    {
        return view("admin.preharvest-categories.create",['level' => 2]);
    }

    public function createSubChildCategory()
    {
        return view("admin.preharvest-categories.create",['level' => 3]);
    }

    public function store(CreatePreharvestCategoryRequest $request)
    {
        $result = $this->service->createCategory($request);

        if($result["success"])
        {
            Alert::success($result["title"], $result["body"]);
            $category = $result['data'];
            if ($category->level == CategoryLevels::PARENT)
            {
                return redirect()->route("admin.preharvest-categories.index");
            }
            elseif($category->level == CategoryLevels::CHILD)
            {
                return redirect()->route("admin.preharvest-categories.show", ["id" => $category->parent_id]);
            }
            elseif($category->level == CategoryLevels::SUBCHILD)
            {
                return redirect()->route("admin.preharvest-categories.showSubCategory", ["id" => $category->parent_id]);
            }
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    public function show(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.preharvest-categories.show", compact('category'));
    }

    public function showSubCategory(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.preharvest-categories.SubShow", compact('category'));
    }

    public function showSubChildCategory(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.preharvest-categories.subChildShow", compact('category'));
    }

    public function edit(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.preharvest-categories.edit", ['category' => $category,'level' => 1]);
    }

    public function editSubCategory(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.preharvest-categories.edit", ['category' => $category,'level' => 2]);
    }

    public function editSubChildCategory(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.preharvest-categories.edit",  ['category' => $category,'level' => 3]);
    }

    public function update(UpdatePreharvestCategoryRequest $request, int $id)
    {
        $result = $this->service->updateCategory($id, $request);

        if($result["success"])
        {
            Alert::success($result["title"], $result["body"]);
            $category = $result['data'];
            if ($category->level == CategoryLevels::PARENT)
            {
                return redirect()->route("admin.preharvest-categories.index");
            }
            elseif($category->level == CategoryLevels::CHILD)
            {
                return redirect()->route("admin.preharvest-categories.show", ["id" => $category->parent_id]);
            }
            elseif ($category->level == CategoryLevels::SUBCHILD)
            {
                return redirect()->route("admin.preharvest-categories.showSubCategory", ["id" => $category->parent_id]);
            }
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    public function updateCategoryOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        $cases = [];
        $ids = [];
        $params = [];
        foreach ($request->data as $value)
        {
            $id = (int)$value['id'];
            $cases[] = "WHEN {$id} then ?";
            $params[] = (int)$value['order'];
            $ids[] = $id;
        }
        $ids = implode(',', $ids);
        $cases = implode(' ', $cases);
        $params[] = Carbon::now();
        DB::update("UPDATE `categories` SET `order` = CASE `id` {$cases} END, `updated_at` = ? WHERE `id` in ({$ids})", $params);
        return response()->json(['status' => 'success'],200);
    }

    public function destroy(int $id)
    {
        $result = $this->service->deleteCategory($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->back();
    }
}
