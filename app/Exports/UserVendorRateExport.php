<?php

namespace App\Exports;

use App\Models\OrderProcessRate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserVendorRateExport implements FromCollection,WithHeadings,WithMapping
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
            'اسم التاجر',
            'التقييم',
            'اسم الأدمن',
            'حالة الموافقة',
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
            $item->customer?->name  ?? NULL,
            $item->vendor?->name  ?? NULL,
            $item->rate  ?? NULL,
            $item->admin?->name  ?? NULL,
            \App\Enums\AdminApprovedState::getStateWithClass($item->admin_approved)["name"],
        ];
       
    }
  
}
