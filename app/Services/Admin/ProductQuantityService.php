<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Http\Request;
use App\Repositories\Admin\ProductQuantityRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductQuantityService
{
    /**
     * Product Quantity Service Constructor.
     *
     * @param ProductQuantityRepository $repository
     */
    public function __construct(public ProductQuantityRepository $repository) {}

    /**
     * Get ProductQuantities.
     *
     * @return Collection
     */
    public function getAllProductQuantities() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get ProductQuantities with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllProductQuantitiesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $productQuantities = $this->repository
                    ->all()
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $productQuantities->where('name->' . $request->trans, 'LIKE', "%{$request->search}%");
            }
        }

        if ($request->has("is_active") && $request->is_active !== "all") {
            $productQuantities->where("is_active", "=", $request->is_active);
        }

        return $productQuantities->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get ProductQuantity using ID.
     *
     * @param integer $id
     * @return ProductQuantity
     */
    public function getProductQuantityUsingID(int $id) : ProductQuantity
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New ProductQuantity.
     *
     * @param Request $request
     * @return array
     */
    public function createProductQuantity(Request $request) : array
    {

        $productQuantity = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($productQuantity)) {
            return [
                "success" => true,
                "title" => trans("admin.productQuantities.messages.created_successfully_title"),
                "body" => trans("admin.productQuantities.messages.created_successfully_body"),
                "id" => $productQuantity->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.productQuantities.messages.created_error_title"),
            "body" => trans("admin.productQuantities.messages.created_error_body"),
        ];
    }

    /**
     * Update Product Quantity Using ID.
     *
     * @param integer $product_quantity_id
     * @param Request $request
     * @return array
     */
    public function updateProductQuantity(int $product_quantity_id, Request $request) : array
    {
        $productQuantity = $this->getProductQuantityUsingID($product_quantity_id);

        $this->repository->update($request->except('_method', '_token'), $productQuantity);

        return [
            "success" => true,
            "title" => trans("admin.productQuantities.messages.updated_successfully_title"),
            "body" => trans("admin.productQuantities.messages.updated_successfully_body"),
            "id" => $product_quantity_id
        ];
    }

    /**
     * Delete Product Quantity Using.
     *
     * @param int $product_quantity_id
     * @return array
     */
    public function deleteProductQuantity(int $product_quantity_id) : array
    {
        $falseBody = trans("admin.productQuantities.messages.deleted_error_message");
        $productQuantity = $this->getProductQuantityUsingID($product_quantity_id);
        if ($productQuantity->products()->first()) {
            $isDeleted = false;
            $falseBody = trans("admin.cant-delete-related-to-product");
        } else $isDeleted = $this->repository->delete($productQuantity);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.productQuantities.messages.deleted_successfully_title"),
                "body" => trans("admin.productQuantities.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.productQuantities.messages.deleted_error_title"),
            "body" => $falseBody,
        ];
    }
}
