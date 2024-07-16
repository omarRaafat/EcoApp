<?php
namespace App\Http\Controllers\Admin;

use App\Enums\CouponDiscountType;
use App\Enums\CouponStatus;
use App\Enums\CouponType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponStorFormRequest;
use App\Http\Requests\Admin\CouponUpdateFormRequest;
use App\Http\Resources\Admin\CouponResource;
use App\Http\Resources\Admin\CouponsResource;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Vendor;
use App\Services\Admin\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use RealRashid\SweetAlert\Facades\Alert;

class CouponController extends Controller
{
    /**
     * Summary of couponService
     * @var mixed
     */
    public $couponService;

    /**
     * Summary of __construct
     * @param CouponService $couponService
     */
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    /**
     * Summary of index
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $coupons = CouponsResource::collection($this->couponService->getAllCouponsWithPagination($request));
        return view("admin.coupons.index", compact('coupons'));
    }

    /**
     * Summary of create
     * @return mixed
     */
    public function create()
    {
        $couponStatus = CouponStatus::getStatusListWithClass();
        $discountTypes = CouponDiscountType::getStatusListWithClass();
        $couponTypes = CouponType::getCouponListWithClass();
        $vendors = Vendor::select('id','name->ar AS vendorName')->get();
        $breadcrumbParent = 'admin.coupons.index';
        $breadcrumbParentUrl = route('admin.coupons.index');
        /*$products = Product::select('id','name->ar AS productName')->paginate(10);*/
        return view(
            "admin.coupons.create",
            compact("couponStatus", 'discountTypes', 'couponTypes', 'vendors', 'breadcrumbParent', 'breadcrumbParentUrl')
        );
    }

    /**
     * Summary of store
     * @param CouponStorFormRequest $request
     * @return mixed
     */
    public function store(CouponStorFormRequest $request)
    {
        $result = $this->couponService->createCoupon($request);
        if($result["success"] == TRUE)
        {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.coupons.index");
        }
        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Summary of show
     * @param int $id
     * @return mixed
     */
    public function show(int $id)
    {
        /*$coupon = new CouponResource($this->couponService->getCouponUsingID($id));
        $breadcrumbParent = 'admin.coupons.index';
        $breadcrumbParentUrl = route('admin.coupons.index');*/

        $coupon = new CouponResource($this->couponService->getCouponUsingID($id));
        $discountTypes = CouponDiscountType::getStatusListWithClass();
        $couponTypes = CouponType::getCouponListWithClass();
        $vendors = Vendor::select('id','name->ar AS vendorName')->get();
        $products = [];
        $breadcrumbParent = 'admin.coupons.index';
        $breadcrumbParentUrl = route('admin.coupons.index');
        if($coupon->coupon_type == 'product')
        {
            $products = Product::select('id','name->ar AS productName')->whereIn("id",$coupon->CouponMeta->related_ids)->get();
        }

        return view("admin.coupons.show", compact(
            'coupon', 'couponTypes', 'discountTypes',
            'vendors','products', 'breadcrumbParent', 'breadcrumbParentUrl'
        ));
    }

    /**
     * Summary of edit
     * @param int $id
     * @return mixed
     */
    public function edit(int $id)
    {
        $coupon = new CouponResource($this->couponService->getCouponUsingID($id));
        $discountTypes = CouponDiscountType::getStatusListWithClass();
        $couponTypes = CouponType::getCouponListWithClass();
        $vendors = Vendor::select('id','name->ar AS vendorName')->get();
        $products = [];
        $breadcrumbParent = 'admin.coupons.index';
        $breadcrumbParentUrl = route('admin.coupons.index');
        if($coupon->coupon_type == 'product')
        {
            $products = Product::select('id','name->ar AS productName')->whereIn("id",$coupon->CouponMeta->related_ids)->get();
        }
        return view(
            "admin.coupons.edit",
            compact(
                'coupon', 'couponTypes', 'discountTypes',
                'vendors','products', 'breadcrumbParent', 'breadcrumbParentUrl'
            )
        );
    }

    /**
     * Summary of update
     * @param CouponUpdateFormRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(CouponUpdateFormRequest $request, int $id)
    {
        $result = $this->couponService->updateCoupon($id, $request);
        if($result["success"] == TRUE)
        {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.coupons.index", $id);
        }
        Alert::error($result["title"]);
        return redirect()->back();
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        $result = $this->couponService->deleteCoupon($id);
        if($result["success"] == TRUE)
        {
            Alert::success($result["title"], $result["body"]);
        }
        else
        {
            Alert::error($result["title"], $result["body"]);
        }
        return redirect()->route('admin.coupons.index');
    }

    /**
     * Summary of changeStatus
     * @param Coupon $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Coupon $coupon): \Illuminate\Http\JsonResponse
    {
        $selected_status = request('selected');
        $message = '';
        if($coupon->status != $selected_status && $selected_status && array_key_exists($selected_status,CouponStatus::getStatusList()))
        {
            $coupon->status = $selected_status;
            $coupon->save();
            $message = trans('admin.coupons.' . $coupon->status);
        }
        return response()->json(['status' => 'success', 'data' => $coupon->status, 'message' => $message], 200);
    }

    function product($query)
    {
        $products = Product::select('id','name->ar AS text')
            ->where('name', 'LIKE', "%{$query}%")
            ->take(5)->get()->toArray();
        return ['results' => $products];
    }
}
