<?php

namespace App\Exports;

use App\Models\TransactionProcessRate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionProcessRateExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $items;

    public function __construct($items)
    {
        $this->items = $items;
    }


  
    public function headings(): array
    {
        $_titles = [
            'العميل',
            'رقم الجوال',
            'الطلب الرئيسي',
            'سهولة وسرعة الوصول',
            "دقة وتوافق وحداثة المعلومات",
            "سرعة التصفح والتنقل",
            "الإستجابة للشكاوى والإستفسارات",
            "متوسط التقييم ",
            "بتاريخ"
        ];

        return $_titles;
    }

    public function collection()
    {
        return $this->items;
    }
    
     public function map($item): array
    {   

        return [
            $item->transaction->customer->name  ?? NULL,
            $item->transaction->customer->phone  ?? NULL,
            $item->transaction->code  ?? NULL,
            $item->EaseSpeed,
            $item->FreshnessInformation,
            $item->EaseUse,
            $item->ContactSupport,
            $item->avgRating(),
            $item->created_at,
        ];
       
    }
  
}
