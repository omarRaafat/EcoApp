<?php

namespace App\Exports\Reports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VendorsEarningsExport implements FromCollection, WithMapping, WithHeadings
{

    protected $orders;
    protected $count_number = 1;
    protected $vendor_counts;
    protected $sum_earn;

    public function __construct($orders,$sum_earn,$vendor_counts)
    {
        $this->orders = $orders;
        $this->sum_earn = $sum_earn;
        $this->vendor_counts = $vendor_counts;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            [
                ' نوع الملف',
                ' رقم الشريك/الحساب المختصر',
                ' رقم الحساب كاملا',
                ' اسم العميل',
                ' عدد المستفيدين',
                ' المبلغ الاجمالي ',
                ' اللغة',
                ' رقم النسخه',
            ],
            [
                'Bulk Fund Transfer ',
                '3073724',
                ' ',
                'National Center for Palms and Dates',
                $this->vendor_counts,
                $this->sum_earn,
                'Ar',
                '2.24',
            ],
            [
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
            ],
            [
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
            ],
            [
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
                ' ',
            ],

            [
                'التسلسل ',
                'اسم المستفيد',
                'اسم المنشأة (كما في السجل التجاري)',
                'الاسم المسجل في البنك ',
                ' رقم حساب المستفيد',
                ' بنك المستفيد',
                ' المبلغ بالريال',
                '  تفاصيل العملية 1',
                '  تفاصيل العملية 2',
                '  تفاصيل العملية 3',
                '  الغرض من التحويل',
            ]
        ];
    }

    public function map($vendor): array
    {

        return [
            $this->count_number++,
            $vendor->owner->name,
            $vendor->name,
            $vendor->name_in_bank,
            $vendor->ipan,
            $vendor->bank->swift_code,
            round(($vendor->vendorWalletTransactionIn - $vendor->vendorWalletTransactionOut),2) ,
            $vendor->name
        ];
    }

}
