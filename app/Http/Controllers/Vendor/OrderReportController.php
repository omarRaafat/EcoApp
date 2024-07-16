<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Services\Reports\OrdersReport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;

class OrderReportController extends Controller
{
    public function __construct(
        private readonly OrdersReport $orderReportService
    ) {}

    public function index(Request $request) : View | RedirectResponse {
        
        
        $vendor = auth()->user()->vendor;
        if ($vendor) {
            try {
                $collection = $this->orderReportService->ordersGetBaseQuery($vendor, $request)->paginate(50);
            } catch (Exception $e) {
                return back()->with("error", $e->getMessage());
            }
           
        }
        // return $collection;
        return view("vendor.reports.vendors-orders", ['collection' => $collection ?? collect([])]);
    }

    public function excel(Request $request): ?RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        if ($vendor) {
            try {
                return $this->orderReportService->ordersExcelForVendor($request, $vendor);
            } catch (Exception $e) {
                return back()->with("error", $e->getMessage());
            }
        } else {
            return back()->with("error", "test");
        }
    }

    public function print(Request $request) : View | RedirectResponse {
        $vendor = auth()->user()->vendor;
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
                    "vendor.reports.print-vendors-orders",
                    ['collection' => $this->orderReportService->ordersGetBaseQuery($vendor, $request), 'totals' => $totals, 'vendor' => $vendor]
                );
            } catch (Exception $e) {
                return back()->with("error", $e->getMessage());
            }
        } else {
            return back()->with("error", "test");
        }
    }
}
