<?php

namespace App\Services\Api;


use App\Models\CartProduct;
use Illuminate\Http\Request;
use App\Repositories\Api\CartProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class CartProductService
{
    /**
     * CartProduct Service Constructor.
     *
     * @param CartRepository $repository
     */
    public function __construct(public CartProductRepository $repository) {}

    /**
     * Get carts.
     *
     * @return Collection
     */
    public function getAllcarts() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get CartProducts with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCartProductsWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->paginate($perPage);
    }

    public function getAllCartProductsGroupByVendor()
    {
        
    }

    /**
     * Get CartProduct using ID.
     *
     * @param integer $id
     * @return CartProduct
     */
    public function getCartProductUsingID(int $id) : CartProduct
    {
        return $this->repository->getModelUsingID($id);
    }



}
