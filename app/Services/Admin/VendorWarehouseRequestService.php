<?php

namespace App\Services\Admin;

use App\Events\Warehouse\CreateVendorWarehouseRequest;
use Illuminate\Http\Request;
use App\Integrations\Warehouses\StorageRequest;
use App\Models\VendorWarehouseRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\VendorWarehouseRequestProduct;
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
    public function getAllRequestsWithPagination(Request $request, int $perPage = 20, string $orderBy = "DESC") : LengthAwarePaginator
    {
        return $this->repository
            ->all()
            ->newQuery()
            ->when(
                $request->has("search"),
                fn($q) => $q->whereHas(
                    "vendor",
                    fn($_q) => $_q->where('name', 'like', "%{$request->get("search")}%")
                )
            )
            ->orderBy("created_at", $orderBy)
            ->withCount('requestItems')
            ->paginate($perPage);;

        // if($request->has("status")) {
        //     $wareHouseRequestsItems->where("status", $request->status);
        // }
    }


    public function getRequestWithProducts(int $request_id,Request $request, int $perPage = 20, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $search = $request->get("search", null);
        return $this->requestRepository
            ->all()->where('warehouse_request_id',$request_id)
            ->newQuery()
            ->when(
                $search,
                fn($searchQuery) => $searchQuery->where(
                    fn($whereQuery) => $whereQuery->whereHas(
                        'request.vendor',
                        fn($vendorQuery) => $vendorQuery->where('name', 'LIKE', "%$search%")
                    )
                    ->orWhereHas(
                        'product',
                        fn($prodQuery) => $prodQuery->where(
                            fn($productQuery) =>
                                $productQuery->where('name->ar', 'like', "%$search%")
                                    ->orWhere('name->en', 'like', "%$search%")
                        )
                    )
                )
            )
            ->orderBy("created_at", $orderBy)
            ->paginate($perPage);

        // if($request->has("status")) {
        //     $wareHouseRequestsItems->where("status", $request->status);
        // }
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
            "vendor_id" => $request->vendor_id,
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
