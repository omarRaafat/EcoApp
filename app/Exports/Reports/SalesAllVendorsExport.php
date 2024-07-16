<?php

namespace App\Exports\Reports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesAllVendorsExport implements FromCollection , WithMapping , WithHeadings
{

    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'المتجر',
            'مجموع الطلبات بدون VAT',
            'قيمة الضريبة',
            'مجموع الطلبات مع VAT',
            'عمولة المنصة بدون VAT',
            'قيمة ضريبة عمولة المنصة',
            'عمولة المنصة مع VAT',
            'مستحقات التاجر',
            'خصومات التاجر',
            'الصافي للتاجر',
        ];
    }

    public function map($order): array
    {
        return [
            $order->vendor->name,
            $order->total_without_vat,
            $order->total_vat,
            $order->total_with_vat,
            $order->total_company_profit_without_vat,
            $order->value_of_company_profit_vat,
            $order->total_company_profit,
            $order->total_balance,
            $order->totalVendorOut(),
            $order->total_balance - $order->totalVendorOut(),

        ];
    }

}
