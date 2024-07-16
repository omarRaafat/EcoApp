<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\VendorWarehouseRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\VendorWarehouseRequestProduct;
use App\Integrations\Warehouses\StorageRequest;
use App\Events\Warehouse\CreateVendorWarehouseRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Admin\VendorWarehouseRequestRepository;
use App\Repositories\Admin\VendorWarehouseRequestProductRepository;

class VendorWarehouseRequestService
{
    /**
     * VendorWarehouseReques Service Constructor.
     *
     * @param VendorWarehouseRequestRepository $repository
     * @param VendorWarehouseRequestProductRepository $requestRepository
     */
    public function __construct(
        public VendorWarehouseRequestRepository $repository,
        public VendorWarehouseRequestProductRepository $requestRepository
    ) {}

    /**
     * Get Requests.
     *
     * @return Collection
     */
    public function getAllRequests() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Requests with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllRequestsWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $wareHouseRequestsItems = $this->repository
                    ->all()->where('vendor_id',auth()->user()->vendor->id)
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("vendor")) {
                $wareHouseRequestsItems->whereHas("request.vendor", function (Builder $query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->input('search')}%");
                });
            }

            if($request->has("product_ar")) {
                $wareHouseRequestsItems->whereHas("product", function (Builder $query) use ($request) {
                    $query->where('name->ar', 'LIKE', "%{$request->input('search')}%");
                });
            }

            if($request->has("product_en")) {
                $wareHouseRequestsItems->whereHas("product", function (Builder $query) use ($request) {
                    $query->where('name->en', 'LIKE', "%{$request->input('search')}%");
                });
            }
        }

        if($request->has("status")) {
            $wareHouseRequestsItems->where("status", $request->status);
        }

        return $wareHouseRequestsItems->orderBy("created_at", $orderBy)->withCount('requestItems')->paginate($perPage);
    }

    public function getRequestWithProducts(int $request_id,Request $request, int $perPage = 20, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $wareHouseRequestsItems = $this->requestRepository
                    ->all()->where('warehouse_request_id',$request_id)
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("vendor")) {
                $wareHouseRequestsItems->whereHas("request.vendor", function (Builder $query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->input('search')}%");
                });
            }

            if($request->has("product_ar")) {
                $wareHouseRequestsItems->whereHas("product", function (Builder $query) use ($request) {
                    $query->where('name->ar', 'LIKE', "%{$request->input('search')}%");
                });
            }

            if($request->has("product_en")) {
                $wareHouseRequestsItems->whereHas("product", function (Builder $query) use ($request) {
                    $query->where('name->en', 'LIKE', "%{$request->input('search')}%");
                });
            }
        }

        if($request->has("status")) {
            $wareHouseRequestsItems->where("status", $request->status);
        }

        return $wareHouseRequestsItems->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Requests using ID.
     *
     * @param integer $id
     * @return VendorWarehouseRequestProduct
     */
    public function getRequestsUsingID(int $id) : VendorWarehouseRequestProduct
    {
        return $this->requestRepository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New VendorWarehouseReques.
     *
     * @param Request $request
     * @return array
     */
    public function createRequest(Request $request) : array
    {       
        $wareHouseRequest = VendorWarehouseRequest::create([
            "vendor_id" => auth()->user()->vendor->id,
            "created_by" => auth()->user()->type,
            "created_by_id" => auth()->user()->id
        ]);

        foreach($request->requestItems as $item) {
            VendorWarehouseRequestProduct::create([
                "warehouse_request_id" => $wareHouseRequest->id,
                "product_id" => $item["product_id"],
                "qnt" => $item["qnt"],
                "mnfg_date" => $item["mnfg_date"],
                "expire_date" => $item["expire_date"]
            ]);
        }

        if(!empty($wareHouseRequest)) {
            event(new CreateVendorWarehouseRequest($wareHouseRequest->load(["requestItems.product"])));
            return [
                "success" => true,
                "title" => trans("admin.wareHouseRequests.messages.created_successfully_title"),
                "body" => trans("admin.wareHouseRequests.messages.created_successfully_body"),
                "id" => $wareHouseRequest->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.wareHouseRequests.messages.created_error_title"),
            "body" => trans("admin.wareHouseRequests.messages.created_error_body"),
        ];
    }

    /**
     * Delete Request Using.
     *
     * @param int $request_id
     * @return array
     */
    public function deleteRequest(int $request_id) : array
    {
        $wareHouseRequest = $this->getRequestsUsingID($request_id);
        $isDeleted = $this->requestRepository->delete($wareHouseRequest);
        
        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.wareHouseRequests.messages.deleted_successfully_title"),
                "body" => trans("admin.wareHouseRequests.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.wareHouseRequests.messages.deleted_error_title"),
            "body" => trans("admin.wareHouseRequests.messages.deleted_error_message"),
        ];
    }
}
