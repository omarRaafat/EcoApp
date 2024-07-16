<?php

namespace App\Services\Admin;

use App\Models\ProductWarehouseStock;
use Exception;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Repositories\Admin\WarehouseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WarehouseService
{
    /**
     * Warehouse Service Constructor.
     *
     * @param WarehouseRepository $repository
     */
    public function __construct(public WarehouseRepository $repository) {}

    /**
     * Get Warehouse.
     *
     * @return Collection
     */
    public function getAllWarehouse() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Warehouse with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllWarehousesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $warehouses = $this->repository
                    ->all()
                    // ->active()
                    ->newQuery();

        if($request->search) {
            if($request->has("trans") && $request->trans != "all") {
                $warehouses->where('name->' . $request->trans, 'LIKE', "%{$request->search}%");
            }else{
                $warehouses = $warehouses->where('name->ar', 'LIKE', "%{$request->search}%")
                ->orwhere('name->en', 'LIKE', "%{$request->search}%");

            }
        }

        if($request->vendor_id) {
            $warehouses = $warehouses->where('vendor_id', $request->vendor_id);
        }

        if($request->warehouse_type) {
            $warehouses = $warehouses->whereHas('shippingTypes', function ($qr) {
                $qr->where('shipping_type_id' , request()->warehouse_type);
            });
        }

        if($request->status) {
            $statusMap = [
                Warehouse::UPDATED => [Warehouse::UPDATED, Warehouse::UPDATE_REFUSED],
                Warehouse::PENDING => [Warehouse::PENDING, Warehouse::REJECTED],
            ];

            $warehouses = $warehouses->whereHas('getLastStatus', function($qr) use($request,$statusMap){
                $qr->whereIn('status', $statusMap[$request->status] ?? [$request->status]);
            });
        }
       

        return $warehouses->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Warehouse using ID.
     *
     * @param integer $id
     * @return Warehouse
     */
    public function getWarehouseUsingID(int $id) : Warehouse
    {
        return $this->repository
                    ->all()
                    ->select('*')
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Warehouse.
     *
     * @param Request $request
     * @return array
     */
    public function createWarehouse(Request $request) : array
    {
        if (isset($request['days']) && $request['days'] != NULL)
            $request['days'] = json_encode($request->days);

        $warehouse = $this->repository->store(
            $request->except('_method', '_token')
        );

        $warehouse->splInfo()->updateOrCreate(
            ['warehouse_id' => $warehouse->id],
            ['branch_id' => $request->spl_branch_id],
        );

        $cityId = is_array($request['cities']) ? head($request['cities']) : $request['cities'];
        $warehouse->cities()->attach($cityId);
        $warehouse->shippingTypes()->attach($request['shipping_type']);


        if(!empty($warehouse)) {
            return [
                "success" => true,
                "title" => trans("admin.warehouses.messages.created_successfully_title"),
                "body" => trans("admin.warehouses.messages.created_successfully_body"),
                "id" => $warehouse->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.warehouses.messages.created_error_title"),
            "body" => trans("admin.warehouses.messages.created_error_body"),
        ];
    }

    /**
     * Update Warehouse Using ID.
     *
     * @param integer $warehouse_id
     * @param Request $request
     * @return array
     */
    public function updateWarehouse(int $warehouse_id, Request $request) : array
    {
        $warehouse = $this->getWarehouseUsingID($warehouse_id);

        $warehouse->splInfo()->updateOrCreate(
            ['warehouse_id' => $warehouse->id],
            ['branch_id' => $request->spl_branch_id],
        );

        if (isset($request['days']) && $request['days'] != NULL)
            $request['days'] = json_encode($request->days);
        $this->repository->update($request->except('_method', '_token'), $warehouse);

        $cityId = is_array($request['cities']) ? head($request['cities']) : $request['cities'];
        $warehouse->cities()->sync([$cityId]);
        $warehouse->shippingTypes()->sync($request['shipping_type']);



        return [
            "success" => true,
            "title" => trans("admin.warehouses.messages.updated_successfully_title"),
            "body" => trans("admin.warehouses.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Warehouse Using.
     *
     * @param int $warehouse_id
     * @return array
     */
    public function deleteWarehouse(int $warehouse_id) : array
    {
        $warehouse = $this->getWarehouseUsingID($warehouse_id);
        $warehouseProductsIds = $warehouse->warehouseProducts()->pluck('product_warehouse_stocks.id')->toArray();
        foreach($warehouseProductsIds as $id){
            ProductWarehouseStock::query()->find($id)->delete();
        }
        $isDeleted = $this->repository->delete($warehouse);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.warehouses.messages.deleted_successfully_title"),
                "body" => trans("admin.warehouses.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.warehouses.messages.deleted_error_title"),
            "body" => trans("admin.warehouses.messages.deleted_error_message"),
        ];
    }
}
