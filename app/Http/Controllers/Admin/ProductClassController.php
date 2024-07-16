<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Admin\ProductClassService;
use App\Http\Resources\Admin\ProductClassResource;
use App\Http\Requests\Admin\CreateProductClassRequest;
use App\Http\Requests\Admin\UpdateProductClassRequest;

class ProductClassController extends Controller
{
    /**
     * Product Class Controller Constructor.
     *
     * @param ProductClassService $service
     */
    public function __construct(public ProductClassService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $productClasses = ProductClassResource::collection(
            $this->service->getAllProductClassesWithPagination($request)
        );

        return view("admin.productClasses.index", compact('productClasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $breadcrumbParent = 'admin.productClasses.index';
        $breadcrumbParentUrl = route('admin.productClasses.index');

        return view("admin.productClasses.create", compact("breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductClassRequest  $request
     * @return Redirect
     */
    public function store(CreateProductClassRequest $request)
    {
        $result = $this->service->createProductClass($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.productClasses.index");
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
        // $productClasse = new ProductClassResource($this->service->getProductClassUsingID($id));
        // $breadcrumbParent = 'admin.productClasses.index';
        // $breadcrumbParentUrl = route('admin.productClasses.index');

        // return view("admin.productClasses.show", compact('productClasse', "breadcrumbParent", "breadcrumbParentUrl"));
        return redirect()->route('admin.productClasses.index');
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $productClass = new ProductClassResource($this->service->getProductClassUsingID($id));
        $breadcrumbParent = 'admin.productClasses.index';
        $breadcrumbParentUrl = route('admin.productClasses.index');

        return view("admin.productClasses.edit", compact('productClass', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateProductClassRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateProductClassRequest $request, int $id)
    {
        $result = $this->service->updateProductClass($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.productClasses.index");
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Product Class Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deleteProductClass($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.productClasses.index');
    }
}
