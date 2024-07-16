<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\CreateInvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Order;
use App\Models\Vendor;
use App\Services\Invoices\CommissionTaxInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with("vendor")
            ->when(filled($request->vendor_name), function ($vendor_name_query) use ($request) {
                $vendor_name_query->whereHas("vendor", function ($vendor_query) use ($request) {
                    $vendor_query->where("name", "like", "%$request->vendor_name%");
                });
            })
            ->when(filled($request->year), function ($year_query) use ($request) {
                $year_query->whereYear("period_start_at", $request->year);
            })
            ->when(filled($request->month), function ($month_query) use ($request) {
                $month_query->whereMonth("period_start_at", $request->month);
            })
            ->orderByDesc("id")
            ->paginate();

        return view("admin.invoice.index", ["invoices" => $invoices]);
    }

    public function create()
    {
        $vendors = Vendor::whereHas('orders', function ($order_query) {
            $order_query->whereNull("invoice_id")
                ->where("status", "completed");
        })->get();

        return view("admin.invoice.create", ["vendors" => $vendors]);
    }

    public function store(CreateInvoiceRequest $request)
    {
        $period_start_at = Carbon::parse("$request->year-$request->month-01");
        $period_end_at = $period_start_at->copy()->endOfMonth();

        $vendors = Vendor::select([
            "id", "name", "commission",
            "street", "tax_num",
            "commercial_registration_no",
            "second_phone"
        ])->when(filled($request->vendor), function ($query) use ($request) {
            $query->where("id", $request->vendor);
        })->whereHas("orders", function ($query) use ($period_end_at, $period_start_at) {
            $query->notLinkedToInvoice($period_start_at, $period_end_at);
        })->get();

        foreach ($vendors as $vendor) {
            $this->generateInvoice($vendor, $period_start_at, $period_end_at);
        }

        return $this->index($request)->with('success', __('admin.static-content.messages.success'));
    }

    public function generateInvoice(Vendor $vendor, Carbon $period_start_at, Carbon $period_end_at): bool
    {
        $orders_query = Order::notLinkedToInvoice($period_start_at, $period_end_at)
            ->where("vendor_id", $vendor->id);

        if (!$orders_query->exists()) {
            return false;
        }

        $total = round($orders_query->sum("sub_total") * ($vendor->commission / 100), 2);
        $vat_rate = 0.15;
        $vat = round($vat_rate * $total, 2);
        $total_with_vat = $total + $vat;

        DB::transaction(function () use (
            $vendor,
            $period_start_at,
            $period_end_at,
            $orders_query,
            $total,
            $vat,
            $total_with_vat,
            $vat_rate
        ) {
            $invoice = Invoice::create([
                'vendor_id' => $vendor->id,
                'number' => random_int(10000, 99999),
                'period_start_at' => $period_start_at,
                'period_end_at' => $period_end_at,
                'vendor_data' => $vendor->toArray(),
                'total_without_vat' => $total,
                'vat_percentage' => round($vat_rate * 100, 2),
                'vat_amount' => $vat,
                'total_with_vat' => $total_with_vat,
            ]);

            $invoice->invoiceLines()->create([
                'description' => __("Invoice.invoice_line_description_text",
                    ["commission" => $vendor->commission]),
                'unit_price' => $total,
                'quantity' => 1,
                'vat_percentage' => round($vat_rate * 100, 2),
                'total_without_vat' => $total,
                'vat_amount' => $vat,
                'total_with_vat' => $total_with_vat,
            ]);

            $orders_query->update(["invoice_id" => $invoice->id]);
        });

        return true;
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(["orders"]);

        return view("admin.invoice.show", ["invoice" => $invoice]);
    }

    public function printTaxInvoice(Invoice $invoice)
    {
        $invoiceGenerator = new CommissionTaxInvoice;
        $invoiceGenerator->setTransaction($invoice);

        return $invoiceGenerator->getPdf()->stream($invoiceGenerator->getFileName());
    }
}
