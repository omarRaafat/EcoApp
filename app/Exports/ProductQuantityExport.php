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

class ProductQuantityExport implements FromCollection , WithMapping , WithHeadings, WithColumnFormatting,WithColumnWidths,WithEvents
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
            'أسم المتجر',
            'أسم المنتج',
            'الكمية',
        ];
    }

    public function map($product): array
    {

        return [
            $product->id,
            $product->vendor->name,
            $product->name,
            $product->stock . $this->getStock($product)
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
            'D' => 80,
            'E' => 120,
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

    public function getStock($product){

        $warehouseStock = [];
        if($product->vendor->stock_system == 0){
            foreach ($product->warehouseStock as $item){
                $warehouseStock[] = "(" .  $item->warehouse->name .  "=" .  $item->stock ?? 0 .")";

            }
        }
        return implode(' - ' ,$warehouseStock );
    }

}
