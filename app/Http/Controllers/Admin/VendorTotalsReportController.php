<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Services\Reports\OrdersReport;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;

class VendorTotalsReportController extends Controller
{
    private array $selects;
    private array $sumSelectors;

    public function __construct(
        private readonly OrdersReport $orderReportService
    ) {
        $this->sumSelectors = [
            DB::raw("SUM(sub_total) AS sum_sub_total"),
            DB::raw("SUM(vat) AS sum_vat"),
            DB::raw("SUM(vendor_amount) AS sum_vendor_amount"),
            DB::raw("SUM(company_profit) AS sum_company_profit"),
            DB::raw("SUM(
                company_profit - (
                    company_profit * (
                        1 / (
                            1 + (
                                vat_percentage/100
                            )
                        )
                    )
                )
            ) AS sum_company_profit_vat_rate"),
        ];
        $this->selects = array_merge(["vendor_id"], $this->sumSelectors);
    }

    public function totalVendorsOrders(Request $request) {
        $vendors = Vendor::select('name', 'id')->get()->map(fn($e) => ['id' => $e->id, 'name' => $e->getTranslation("name", "ar")]);
        $vendor = request()->has('vendor') ? Vendor::find(request()->get('vendor')) : null;
        try {
            $collection = $this->orderReportService
                ->ordersBaseQuery($request)
                ->when($vendor, fn($q) => $q->vendor($vendor->id))
                ->select($this->selects)
                ->with("vendor")
                ->groupBy("vendor_id")
                ->paginate(50);
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
        return view("admin.reports.totals-vendors-orders.index", [
            'vendors' => $vendors, 'collection' => $collection, 'totals' => $this->getTotals($request, $vendor)
        ]);
    }

    public function totalVendorsOrdersExcel(Request $request): ?RedirectResponse
    {
        try {
            $vendor = request()->has('vendor') ? Vendor::find(request()->get('vendor')) : null;
            $writer = SimpleExcelWriter::streamDownload('تقرير-مبيعات-التجار'.'-'.time() .'.xlsx');
            $writer->addHeader([
                __('reports.total-vendors-orders.vendor'),
                __('reports.total-vendors-orders.total-without-vat'),
                __('reports.total-vendors-orders.vat-rate'),
                __('reports.total-vendors-orders.total-with-vat'),
                __('reports.total-vendors-orders.company-profit-without-vat'),
                __('reports.total-vendors-orders.company-profit-vat-rate'),
                __('reports.total-vendors-orders.company-profit-with-vat'),
                __('reports.total-vendors-orders.vendor-amount'),
            ]);
            $this->orderReportService
                ->ordersBaseQuery($request)
                ->when($vendor, fn($q) => $q->vendor($vendor->id))
                ->select($this->selects)
                ->with("vendor")
                ->groupBy("vendor_id")
                ->orderBy("sum_vendor_amount", "desc")
                ->lazy()
                ->each(function($row) use (&$writer) {
                    $writer->addRow([
                        $row?->vendor?->getTranslation("name", "ar"),
                        amountInSarRounded($row->sum_sub_total),
                        amountInSarRounded($row->sum_vat),
                        amountInSarRounded($row->sum_sub_total + $row->sum_vat),
                        amountInSarRounded($row->sum_company_profit - $row->sum_company_profit_vat_rate),
                        amountInSarRounded($row->sum_company_profit_vat_rate),
                        amountInSarRounded($row->sum_company_profit),
                        amountInSarRounded($row->sum_vendor_amount),
                    ]);
                });
            return $writer->toBrowser();
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function totalVendorsOrdersPrint(Request $request) : View | RedirectResponse {
        $vendor = Vendor::find(request()->get('vendor'));
        try {
            $collection = $this->orderReportService
                ->ordersBaseQuery($request)
                ->when($vendor, fn($q) => $q->vendor($vendor->id))
                ->select($this->selects)
                ->with("vendor")
                ->groupBy("vendor_id")
                ->orderBy("sum_vendor_amount", "desc");
            return view(
                "admin.reports.totals-vendors-orders.print",
                ['collection' => $collection, 'totals' => $this->getTotals($request, $vendor)]
            );
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    private function getTotals(Request $request, ?Vendor $vendor) : array {
        $totals = $this->orderReportService
            ->ordersBaseQuery($request)
            ->when($vendor, fn($q) => $q->vendor($vendor->id))
            ->select($this->sumSelectors)->first();

        return [
            "sub_total_in_sar_rounded" => amountInSar($totals->sum_sub_total ?? 0),
            "vat_in_sar_rounded" => amountInSar($totals->sum_vat ?? 0),
            "total_in_sar_rounded" => amountInSar(($totals->sum_sub_total ?? 0) + ($totals->sum_vat ?? 0)),
            "company_profit_without_vat_in_sar_rounded" => amountInSar(($totals->sum_company_profit ?? 0) - ($totals->sum_company_profit_vat_rate ?? 0)),
            "company_profit_vat_rate_rounded" => amountInSar($totals->sum_company_profit_vat_rate ?? 0),
            "company_profit_in_sar_rounded" => amountInSar($totals->sum_company_profit ?? 0),
            "vendor_amount_in_sar_rounded" => amountInSar($totals->sum_vendor_amount ?? 0),
        ];
    }
}
