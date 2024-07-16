<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MostSellingExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, WithColumnWidths, WithEvents
{
    use Exportable;

    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products->get();
    }

    public function headings(): array
    {
        return [
            'المعرف',
            'نوع المنتج	',
            'اسم المنتج',
            'قيمة المنتج	',
            'عدد مبيعات المنتج',
            'نسبة مبيعات المنتج',
            'عدد عمليات استلام من المتجر',

            // 'User',
            // 'Date',
        ];
    }

    public function map($product): array
    {

        return [
            $product->id,
            $product->category->name,
            $product->name,
            $product->price,
            $product->no_sells == 0 ? '0' : $product->no_sells,
            $product->sellsPercentage == 0 ? '0' : $product->sellsPercentage .' %',
            $product->no_receive_from_vendor == 0 ? '0' : $product->no_receive_from_vendor,

        ];
    }


    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,

        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 30,
            'D' => 15,
            'E' => 30,
            'F' => 30,
            'G' => 30,

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:H')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

}
