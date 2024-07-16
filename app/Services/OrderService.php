<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Vendor\OrderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    /**
     * Order Service Constructor.
     *
     * @param OrderRepository $repository
     */
    public function __construct(public OrderRepository $repository) {}

    /**
     * Get Orders.
     *
     * @return Collection
     */
    public function getAllOrders() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Orders with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllOrdersWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->paginate($perPage);
    }

    /**
     * Get Order using ID.
     *
     * @param integer $id
     * @return Order
     */
    public function getOrderUsingID(int $id) : Order
    {
        return $this->repository->getModelUsingID($id);
    }
    /**
     * Get Orders using IDs.
     *
     * @param array $ids
     * @return Order
     */
    public function getOrderCollectionUsingIDs(int $ids) : Collection
    {
        return $this->repository->getModelCollectionUsingIDs($ids);
    }

    /**
     * Get Orders with pagination By category id.
     *
     * @param integer $vendor_id
     * @return LengthAwarePaginator
     */
    public function getOrdersUsingVendorID(int $vendor_id) : Collection
    {
        return $this->repository->all()->where('vendor_id',$vendor_id)->orderBy('id','desc')->get();
    }

    public function getOrdersUsingAuthVendorID() : Collection
    {
        $user=auth()->user();
        return $this->repository->all()->where('vendor_id',$user->vendor_id)->orderBy('id','desc')->get();
    }

    public function delete($id)
    {
        $model=$this->repository->getModelUsingID($id);
        $this->repository->delete($model);
        return true;
    }

    public function multiDelete($ids)
    {
        $model=$this->repository->getModelCollectionUsingIDs($ids);
        $model->delete($model);
        return true;
    }
}
