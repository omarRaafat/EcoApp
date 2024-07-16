<?php
namespace App\Services\Reports;

use App\Models\Order;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Closure;

class OrdersReport
{
    public function ordersExcelForAdmin(Request $request, Vendor $vendor) {
        return $this->vendorsOrdersExcel(
            $request,
            $vendor,
            array_merge([__('reports.vendors-orders.vendor')], $this->getBaseHeader()),
            fn($r) : array => array_merge([$r?->vendor?->getTranslation("name", "ar")], $this->baseRow($r))
        );
    }

    public function ordersExcelForVendor(Request $request, Vendor $vendor) {
        return $this->vendorsOrdersExcel(
            $request,
            $vendor,
            $this->getBaseHeader(),
            fn($r) : array => $this->baseRow($r)
        );
    }

    public function ordersGetBaseQuery(Vendor $vendor, Request $request) : Builder {
        return $this->ordersBaseQuery($request)->vendor($vendor->id)->descOrder();
    }

    public function ordersBaseQuery(Request $request) : Builder {
        $dateFrom = $request->has('from') && $request->get('from') != '' ? Carbon::parse($request->get('from')) : null;
        $dateTo = $request->has('to') && $request->get('to') != '' ? Carbon::parse($request->get('to')) : null;

        return Order::query()
            ->with(['vendor' => fn($v) => $v->select('name', 'id')])
            ->delivered()
            ->whereHas('vendorWalletTransactions',fn($q) => $q->where('status','completed'))
            ->when($dateFrom && $dateTo, function($query) use ($dateFrom, $dateTo, $request) {
                if ($request->has("filter_by") && $request->get("filter_by") == "created") {
                    $query->createdBetween($dateFrom, $dateTo);
                } else {
                    $query->deliveredBetween($dateFrom, $dateTo);
                }
            });
    }

    private function vendorsOrdersExcel(Request $request, Vendor $vendor, array $header, Closure $addRow) {
        $writer = SimpleExcelWriter::streamDownload('تقرير-شحنات-مستلمة'. Str::slug($vendor->getTranslation("name", "ar")) .'-'.time() .'.xlsx');
        $writer->addHeader($header);
        $this->ordersGetBaseQuery($vendor, $request)
            ->lazy()
            ->each(function($row) use (&$writer, &$addRow) {
                $writer->addRow($addRow($row));
            });
        return $writer->toBrowser();
    }

    private function getBaseHeader() : array {
        return [
            __('reports.vendors-orders.order-code'),
            __('reports.vendors-orders.order-id'),
            __('reports.vendors-orders.created-at'),
            __('reports.vendors-orders.delivered-at'),
            __('reports.vendors-orders.total-without-vat'),
            __('reports.vendors-orders.vat-rate'),
            __('reports.vendors-orders.total-with-vat'),
            __('reports.vendors-orders.company-profit-without-vat'),
            __('reports.vendors-orders.company-profit-vat-rate'),
            __('reports.vendors-orders.company-profit-with-vat'),
            __('reports.vendors-orders.vendor-amount'),
        ];
    }

    private function baseRow($row) : array {
        return [
            $row->code,
            $row->id,
            $row->created_at?->toDateString(),
            $row->delivered_at?->toDateString(),
            $row->sub_total. ' '. __("translation.sar"),
            $row->vat. ' '. __("translation.sar") .'('. $row->vat_percentage . '%)',
            $row->total. ' '. __("translation.sar"),
            $row->getCompanyProfitWithOutVatPecentage() . ' '. __("translation.sar"),
            $row->company_profit - ($row->company_profit / "1.$row->vat_percentage") . ' '. __("translation.sar") .'('. $row->vat_percentage . '%)',
            $row->company_profit. ' '. __("translation.sar") .'('. $row->vat_percentage . '%)',
            $row->vendor_amount.' '. __("translation.sar"),
        ];
    }
}
