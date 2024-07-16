<?php

namespace App\Exports;

use App\Models\OrderProcessRate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReviewExport implements FromCollection,WithHeadings,WithMapping
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
            'التقييم',
            'اسم المنتج',
            'اسم الأدمن',
            'تعليق العميل',
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
            $item->user?->name  ?? NULL,
            $item->rate  ?? NULL,
            $item->product?->name,
            $item->admin?->name  ?? NULL,
            $item->comment,
            \App\Enums\AdminApprovedState::getStateWithClass($item->admin_approved)["name"],
        ];
       
    }
  
}
