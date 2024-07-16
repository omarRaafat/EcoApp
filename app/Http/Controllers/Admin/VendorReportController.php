<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Services\Reports\OrdersReport;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VendorReportController extends Controller
{
    public function __construct(
        private readonly OrdersReport $orderReportService
    ) {}

    public function vendorsOrders(Request $request) {
        $vendors = Vendor::select('name', 'id')->get()->map(fn($e) => ['id' => $e->id, 'name' => $e->getTranslation("name", "ar")]);
        $vendor = request()->has('vendor') ? Vendor::find(request()->get('vendor')) : null;
        try {
            if ($vendor) $collection = $this->orderReportService->ordersGetBaseQuery($vendor, $request)->paginate(50);
            else $collection = $this->orderReportService->ordersBaseQuery($request)->descOrder()->paginate(50);
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
        return view("admin.reports.vendors-orders", ['vendors' => $vendors, 'collection' => $collection]);
    }

    public function vendorsOrdersExcel(Request $request): ?RedirectResponse
    {
        $vendor = Vendor::find(request()->get('vendor'));
        if ($vendor) {
            try {
                return $this->orderReportService->ordersExcelForAdmin($request, $vendor);
            } catch (Exception $e) {
                return back()->with("error", $e->getMessage());
            }
        } else {
            return back()->with("error", __("reports.vendor-required"));
        }
    }

    public function vendorsOrdersPrint(Request $request) : View | RedirectResponse {
        $vendor = Vendor::find(request()->get('vendor'));
        if ($vendor) {
            try {
                $totals = [
                    "sub_total_in_sar_rounded" => 0.00,
                    "vat_in_sar_rounded" => 0.00,
                    "total_in_sar_rounded" => 0.00,
                    "company_profit_without_vat_in_sar_rounded" => 0.00,
                    "company_profit_vat_rate_rounded" => 0.00,
                    "company_profit_in_sar_rounded" => 0.00,
                    "vendor_amount_in_sar_rounded" => 0.00,
                ];
                return view(
                    "admin.reports.print-vendors-orders",
                    ['collection' => $this->orderReportService->ordersGetBaseQuery($vendor, $request), 'totals' => $totals, 'vendor' => $vendor]
                );
            } catch (Exception $e) {
                return back()->with("error", $e->getMessage());
            }
        } else {
            return back()->with("error", __("reports.vendor-required"));
        }
    }
}
