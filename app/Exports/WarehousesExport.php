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

class WarehousesExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithEvents
{
    use Exportable;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $this->request['status'] = $this->request['status'] ?: Warehouse::ACCEPTED;

        $warehouses = Warehouse::query();
        if ($this->request->has("search")) {
            if ($this->request->has("trans") && $this->request->trans != "all") {
                $warehouses->where('name->'.$this->request->trans, 'LIKE', "%{$this->request->search}%");
            } else {
                $warehouses = $warehouses->where('name->ar', 'LIKE', "%{$this->request->search}%")
                    ->orwhere('name->en', 'LIKE', "%{$this->request->search}%");

            }
        }
        if(request()->get('vendor_id')) {
            $warehouses = $warehouses->where('vendor_id', request()->get('vendor_id'));
        }

        if(request()->get('warehouse_type')) {
            $warehouses = $warehouses->whereHas('shippingTypes', function ($qr) {
                $qr->where('shipping_type_id' , request()->get('warehouse_type'));
            });
        }

        if(request()->get('status')) {
            $warehouses = $warehouses->whereHas('getLastStatus', function($qr){
                $qr->where('status', request()->get('status'));
            });
        }

        return $warehouses;
    }

    public function headings(): array
    {

        return [
            'معرف المستودع',
            'المتاجر',
            'إسم المستودع',
            'نوع المستودع',
            'مدينة المستودع',
            'إسم  المسؤول  عن المستودع',
            'هاتف  المسؤول  عن المستودع',
            'موقع المدينة',
            'اوقات العمل'
        ];
    }


    public function map($warehouse): array
    {
        return [
            $warehouse->id,
            $warehouse->vendor->name,
            $warehouse->getTranslation('name', 'ar'),
            implode('-',$warehouse->shippingTypes->pluck('title')->toArray()),
            $warehouse->cities[0]?->getTranslation('name','ar'),
            $warehouse->administrator_name,
            $warehouse->administrator_phone,
            $warehouse->latitude.','. $warehouse->longitude,
            $warehouse->time_work_from .' : '. $warehouse->time_work_to
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,

        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 30,
            'D' => 40,
            'E' => 40,
            'F' => 40,
            'G' => 40,
            'H' => 40,
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
