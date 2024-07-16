<?php

namespace App\Services\Admin;

use Exception;
use App\Models\ProductClass;
use Illuminate\Http\Request;
use App\Services\LogService;
use App\Repositories\Admin\ProductClassRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductClassService
{
    /**
     * ProductClass Service Constructor.
     *
     * @param ProductClassRepository $repository
     * @param LogService $logger
     */
    public function __construct(
        public ProductClassRepository $repository,
        public LogService $logger
    ) {}

    /**
     * Get ProductClasses.
     *
     * @return Collection
     */
    public function getAllProductClasses() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get ProductClasses with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllProductClassesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $productClasses = $this->repository
                    ->all()
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $productClasses->where('name->' . $request->trans, 'LIKE', "%{$request->input('search')}%");
            }
        }

        return $productClasses->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get ProductClass using ID.
     *
     * @param integer $id
     * @return ProductClass
     */
    public function getProductClassUsingID(int $id) : ProductClass
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New ProductClass.
     *
     * @param Request $request
     * @return array
     */
    public function createProductClass(Request $request) : array
    {
       
        $productClass = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($productClass)) {
            $this->logger->InLog([
                'user_id' => auth()->user()->id,
                'action' => "CreateProductClass",
                'model_type' => "\App\Models\ProductClass",
                'model_id' => $productClass->id,
                'object_before' => null,
                'object_after' => $productClass
            ]);

            return [
                "success" => true,
                "title" => trans("admin.productClasses.messages.created_successfully_title"),
                "body" => trans("admin.productClasses.messages.created_successfully_body"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.productClasses.messages.created_error_title"),
            "body" => trans("admin.productClasses.messages.created_error_body"),
        ];
    }

    /**
     * Update ProductClass Using ID.
     *
     * @param integer $product_class_id
     * @param Request $request
     * @return array
     */
    public function updateProductClass(int $product_class_id, Request $request) : array
    {

        $productClass = $this->getProductClassUsingID($product_class_id);
        $oldproductClassObject = clone $productClass;
        $this->repository->update($request->except('_method', '_token'), $productClass);

        $this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "UpdateProductClass",
            'model_type' => "\App\Models\ProductClass",
            'model_id' => $product_class_id,
            'object_before' => $oldproductClassObject,
            'object_after' => $productClass
        ]);

        return [
            "success" => true,
            "title" => trans("admin.productClasses.messages.updated_successfully_title"),
            "body" => trans("admin.productClasses.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete ProductClass Using.
     *
     * @param int $product_class_id
     * @return array
     */
    public function deleteProductClass(int $product_class_id) : array
    {
        $falseBody = trans("admin.productClasses.messages.deleted_error_message");
        $productClass = $this->getProductClassUsingID($product_class_id);
        if ($productClass->products()->first()) {
            $isDeleted = false;
            $falseBody = trans("admin.cant-delete-related-to-product");
        } else {
            $oldproductClassObject = clone $productClass;
            $isDeleted = $this->repository->delete($productClass);
        }
        if($isDeleted == true) {
            $this->logger->InLog([
                'user_id' => auth()->user()->id,
                'action' => "DeleteProductClass",
                'model_type' => "\App\Models\ProductClass",
                'model_id' => $productClass->id,
                'object_before' => $oldproductClassObject,
                'object_after' => $productClass
            ]);

            return [
                "success" => true,
                "title" => trans("admin.productClasses.messages.deleted_successfully_title"),
                "body" => trans("admin.productClasses.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.productClasses.messages.deleted_error_title"),
            "body" => $falseBody,
        ];
    }
}
