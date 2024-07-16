<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class VendorWarehousesExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithEvents
{
    use Exportable;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
       return Warehouse::query()->where('vendor_id' , auth()->user()->vendor_id)->when(
        $this->request->filled('trans') && $this->request->filled('search') && $this->request->get('trans') != 'all',
        fn($q) => $q->where('name->'.$this->request->get('trans') , 'like' , '%'.$this->request->get('search').'%')
       )->when(
        $this->request->filled('search'),
        fn($q) => fn($subq) => $subq->where('name->ar' , 'like' , '%'.$this->request->get('search').'%')
                               ->orWhere('name->en' , 'like' , '%'.$this->request->get('search').'%') 
       );
    }

    public function headings(): array
    {

        return [
            'معرف المستودع',
            'إسم المستودع',
            'نوع المستودع',
            'إسم  المسؤول  عن المستودع'
        ];
    }


    public function map($warehouse): array
    {
        return [
            $warehouse->id,
            $warehouse->getTranslation('name', 'ar'),
            implode('-',$warehouse->shippingTypes->pluck('title')->toArray()),
            $warehouse->administrator_name
           
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'B' => NumberFormat::FORMAT_TEXT,
            // 'C' => NumberFormat::FORMAT_TEXT,
            // 'D' => NumberFormat::FORMAT_TEXT,
            // 'E' => NumberFormat::FORMAT_TEXT,
           

        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 30,
            'D' => 40,
           
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

    /**
     * @param  Warehouse  $warehouse
     * @return string
     */
    public function getShippingType(Warehouse $warehouse): string
    {
        $shippings = [];
        foreach ($warehouse->shippingTypes as $shipping_type) {
            $shippings[] = $shipping_type->title;

        }
        return implode(' - ', $shippings);
    }
}
