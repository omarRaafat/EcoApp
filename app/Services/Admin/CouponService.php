<?php
namespace App\Services\Admin;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\CouponMeta;
use App\Repositories\Admin\CouponRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CouponService
{
    public $couponRepository;
    /**
     * Coupon Service Constructor.
     *
     * @param CouponRepository $repository
     */
    public function __construct(CouponRepository $couponRepository) {

        $this->couponRepository=$couponRepository;
    }
    /**
     * Get Countries.
     *
     * @return Collection
     */
    public function getAllCoupons() : Collection
    {
        return $this->couponRepository->all()->get();
    }
     /**
     * Get Country using ID.
     *
     * @param integer $id
     * @return Country
     */
    public function getCouponUsingID(int $id) : Coupon
    {
        return Coupon::findOrFail($id);
    }
    /**
     * Get Countries with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllCouponsWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $coupons = Coupon::query();

        if($request->has("search")) {
            if(isset($request->trans) && $request->trans != "all") {
                $coupons->where('title->'.$request->trans, 'LIKE', "%{$request->search}%");
            }
        }

        if (isset($request->status) && $request->status !== "all") {
            $coupons->where("status", $request->status);
        }

        return $coupons->orderBy("id", $orderBy)->paginate($perPage);
    }
    /**
     * Create New Country.
     *
     * @param Request $request
     * @return array
     */
    public function createCoupon(Request $request) : array
    {

        $coupon = $this->couponRepository->store(
            $request->except('_method', '_token')
        );

        if($request->coupon_type == 'vendor')
        {
            CouponMeta::create([
                "related_ids" => $request->vendors,
                "coupon_id" => $coupon->id,
                "related_models" => "Vendor"
            ]);
        }

        if($request->coupon_type == 'product')
        {
            CouponMeta::create([
                "related_ids" => (array)$request->products,
                "coupon_id" => $coupon->id,
                "related_models" => "Product"
            ]);
        }

        if(!empty($coupon)) {
            return [
                "success" => true,
                "title" => trans("admin.coupons.messages.created_successfully_title"),
                "body" => trans("admin.coupons.messages.created_successfully_body"),
                "id" => $coupon->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.countries.messages.created_error_title"),
            "body" => trans("admin.countries.messages.created_error_body"),
        ];
    }
    /**
     * Update Country Using ID.
     *
     * @param integer $country_id
     * @param Request $request
     * @return array
     */
    public function updateCoupon(int $coupon_id, $request) : array
    {
        $coupon = $this->getCouponUsingID($coupon_id);

        $this->couponRepository->update($request->except('_method', '_token'), $coupon);

        if($request->coupon_type == 'vendor')
        {
            CouponMeta::where('coupon_id', '=', $coupon->id)
                ->update(["related_ids" => $request->vendors,"related_models" => "Vendor"]);
        }

        if($request->coupon_type == 'product')
        {
            CouponMeta::where('coupon_id', '=', $coupon->id)
                ->update(["related_ids" => $request->products,"related_models" => "product"]);
        }

        return [
            "success" => true,
            "title" => trans("admin.coupons.messages.updated_successfully_title"),
            "body" => trans("admin.coupons.messages.updated_successfully_body"),
        ];
    }
    /**
     * Delete Country Using.
     *
     * @param int $country_id
     * @return array
     */
    public function deleteCoupon(int $country_id) : array
    {
        $coupon = $this->getCouponUsingID($country_id);
        $isDeleted = $this->couponRepository->delete($coupon);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.coupons.messages.deleted_successfully_title"),
                "body" => trans("admin.coupons.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.coupons.messages.deleted_error_title"),
            "body" => trans("admin.coupons.messages.deleted_error_message"),
        ];
    }
}
