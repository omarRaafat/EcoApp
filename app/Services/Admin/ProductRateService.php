<?php

namespace App\Services\Admin;

use App\Enums\AdminApprovedState;
use Exception;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Database\Query\Builder;
use App\Repositories\Admin\ProductRateRepository;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exports\ReviewExport;
use Excel;

class ProductRateService
{
    /**
     * Product Rate Service Constructor.
     *
     * @param ProductRateRepository $repository
     */
    public function __construct(public ProductRateRepository $repository,
    public ProductRepository $productRepository) {}

    /**
     * Get Products Rates.
     *
     * @return Collection
     */
    public function getAllProductRates() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Products Rates with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllProductRatesWithPagination(Request $request, int $perPage = 50, string $orderBy = "DESC")
    {
        $productRates = $this->repository
            ->all()
            ->newQuery()
            ->when(
                $request->has('search') &&
                $request->has('relation') && 
                in_array($request->get('relation'), Review::ALLOWED_FILTER_RELATION),
                fn ($q) => $q->whereHas(
                    $request->get('relation'),
                    fn ($relation) => $relation->where('name', 'like', "%{$request->search}%")
                )
            )
            ->when(
                $request->has("admin_approved") && $request->filled("admin_approved"), fn($q) => 
                     $q->where('admin_approved' , $request->get("admin_approved"))
                
            )
            ->filterPeriod()->filterAvgRating();
        
        if($request->action == "exportExcel"){
            $filename = date('Ymd_H').'ProductRates.xlsx';
            return Excel::download(new ReviewExport($productRates->orderBy("created_at", $orderBy)->get()), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }

        return $productRates->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Product Rate using ID.
     *
     * @param integer $id
     * @return Review
     */
    public function getProductRateUsingID(int $id) : Review
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Update ProductRate Using ID.
     *
     * @param integer $review_id
     * @param Request $request
     * @return array
     */
    public function updateProductRate(int $review_id, Request $request) : array
    {
        $request->merge([
            "admin_id" => auth()->user()->id,
        ]);

        $productRate = $this->getProductRateUsingID($review_id);
        $this->repository->update($request->except('_method', '_token'), $productRate);
        $this->productRepository->calculateRate($productRate->product_id);       
    

        return [
            "success" => true,
            "title" => trans("admin.productRates.messages.updated_successfully_title"),
            "body" => trans("admin.productRates.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Product Rate Using.
     *
     * @param int $review_id
     * @return array
     */
    public function deleteProductRate(int $review_id) : array
    {
        $productRate = $this->getProductRateUsingID($review_id);
        $isDeleted = $this->repository->delete($productRate);
        
        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.productRates.messages.deleted_successfully_title"),
                "body" => trans("admin.productRates.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.productRates.messages.deleted_error_title"),
            "body" => trans("admin.productRates.messages.deleted_error_message"),
        ];
    }
}
