<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\ProductQuantityStatus;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Admin\ProductQuantityService; 
use App\Http\Resources\Admin\ProductQuantityResource;
use App\Http\Requests\Admin\CreateProductQuantityRequest;
use App\Http\Requests\Admin\UpdateProductQuantityRequest;

class ProductQuantityController extends Controller
{
    /**
     * Product Quantity Controller Constructor.
     *
     * @param ProductQuantityService $service
     */
    public function __construct(public ProductQuantityService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $productQuantities = ProductQuantityResource::collection(
            $this->service->getAllProductQuantitiesWithPagination($request)
        );

        return view("admin.productQuantities.index", compact('productQuantities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        $states = ProductQuantityStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.product-quantities.index';
        $breadcrumbParentUrl = route('admin.product-quantities.index');
        return view("admin.productQuantities.create", compact("states", "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductQuantityRequest  $request
     * @return Redirect
     */
    public function store(CreateProductQuantityRequest $request)
    {
        $result = $this->service->createProductQuantity($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.product-quantities.show", $result["id"]);
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
        $productQuantity = new ProductQuantityResource($this->service->getProductQuantityUsingID($id));
        $breadcrumbParent = 'admin.product-quantities.index';
        $breadcrumbParentUrl = route('admin.product-quantities.index');
        return view("admin.productQuantities.show", compact('productQuantity', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $states = ProductQuantityStatus::getStatusListWithClass();
        $productQuantity = new ProductQuantityResource($this->service->getProductQuantityUsingID($id));
        $breadcrumbParent = 'admin.product-quantities.index';
        $breadcrumbParentUrl = route('admin.product-quantities.index');

        return view("admin.productQuantities.edit", compact('productQuantity', 'states', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateProductQuantityRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateProductQuantityRequest $request, int $id)
    {
        $result = $this->service->updateProductQuantity($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.product-quantities.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Product Quantity Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deleteProductQuantity($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.product-quantities.index');
    }
}