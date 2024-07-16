<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\CategoryLevels;
use App\Http\Controllers\Controller;
use App\Services\Admin\CetegoryService;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Cetegorys Controller Constructor.
     *
     * @param CetegoryService $service
     */
    public function __construct(
        public CetegoryService $service,
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $categories = CategoryResource::collection(
            $this->service->getAllMainCategoriesWithPagination($request)
        );

        return view("admin.categories.index", compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        return view("admin.categories.create",['level' => 1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function createSubCategory()
    {
        return view("admin.categories.create",['level' => 2]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function createSubChildCategory()
    {
        return view("admin.categories.create",['level' => 3]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest  $request
     * @return Redirect
     */
    public function store(CreateCategoryRequest $request)
    {
        $result = $this->service->createCategory($request);

        if($result["success"])
        {
            Alert::success($result["title"], $result["body"]);
            $category = $result['data'];
            if ($category->level == CategoryLevels::PARENT)
            {
                return redirect()->route("admin.categories.index");
            }
            elseif($category->level == CategoryLevels::CHILD)
            {
                return redirect()->route("admin.categories.show", ["id" => $category->parent_id]);
            }
            elseif($category->level == CategoryLevels::SUBCHILD)
            {
                return redirect()->route("admin.categories.showSubCategory", ["id" => $category->parent_id]);
            }
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function show(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.categories.show", compact('category'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $parent_id
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function showSubCategory(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.categories.SubShow", compact('category'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $parent_id
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function showSubChildCategory(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.categories.subChildShow", compact('category'));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.categories.edit", ['category' => $category,'level' => 1]);
    }

    /**
     * Edit the specified resource.
     *
     * @param int $parent_id
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function editSubCategory(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.categories.edit", ['category' => $category,'level' => 2]);
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function editSubChildCategory(int $id)
    {
        $category = new CategoryResource($this->service->getCategoryUsingID($id));
        return view("admin.categories.edit",  ['category' => $category,'level' => 3]);
    }

    /**
     * Update the category..
     *
     * @param  UpdateCategoryRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $result = $this->service->updateCategory($id, $request);

        if($result["success"])
        {
            Alert::success($result["title"], $result["body"]);
            $category = $result['data'];
            if ($category->level == CategoryLevels::PARENT)
            {
                return redirect()->route("admin.categories.index");
            }
            elseif($category->level == CategoryLevels::CHILD)
            {
                return redirect()->route("admin.categories.show", ["id" => $category->parent_id]);
            }
            elseif ($category->level == CategoryLevels::SUBCHILD)
            {
                return redirect()->route("admin.categories.showSubCategory", ["id" => $category->parent_id]);
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

    /**
     * Delete Category Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
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
