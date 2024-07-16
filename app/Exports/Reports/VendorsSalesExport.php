<?php

namespace App\Exports\Reports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VendorsSalesExport implements FromCollection, WithMapping, WithHeadings
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
                ' المتجر',
                'كود الطلب الفرعي	',
                ' رقم الطلب	',
                ' تاريخ إنشاء الطلب	',
                ' تاريخ تسليم الطلب	',
                ' مجموع الطلب بدون VAT	',
                ' قيمة الضريبة	',
                ' مجموع الطلب مع VAT	',
                ' عمولة المنصة بدون VAT	',
                ' قيمة ضريبة عمولة المنصة	',
                ' عمولة المنصة مع VAT	',
                ' مستحقات التاجر',
                ' خصومات التاجر',
        ];
    }

    public function map($row): array
    {

        return [
            $row?->wallet?->vendor?->getTranslation("name", "ar") ,
            $row->order?->code ,
            $row->order?->id ,
            $row->order?->created_at?->toDateString() ,
            $row->order?->delivered_at?->toDateString() ,
            $row->order?->sub_total_in_sar_rounded * 100  . ' ر.س ',
            $row->order?->vat_in_sar_rounded  * 100  . ' ر.س ',
            $row->order?->total_in_sar_rounded  * 100 . ' ر.س ' ,
            $row->order?->company_profit_without_vat_in_sar_rounded * 100 . ' ر.س ' ,
            $row->order?->company_profit_vat_rate_rounded * 100   . ' ر.س ',
            $row->order?->company_profit_in_sar_rounded * 100   . ' ر.س ',
            ($row->operation_type == 'in' ? $row->amount . ' ر.س ' : '0 ر.س'),
            ($row->operation_type == 'out' ? $row->amount . ' ر.س ' : '0 ر.س')        
        ];
    }

}
