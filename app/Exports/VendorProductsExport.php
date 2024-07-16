<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Enums\ProductStatus;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Events\AfterSheet;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class VendorProductsExport implements FromQuery, WithHeadings , WithMapping, WithColumnFormatting,WithColumnWidths,WithEvents
{
    use Exportable;

    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        // dd($this->request->all());
        $search =  $this->request->has('search') ? $this->request->search : null;
         return Product::query()->where('vendor_id' , auth()->user()->vendor_id)->when(
            $search,
            fn($q) => $q->where(
                fn($subQ) => $subQ->where('name->ar', 'like', "%$search%")
                    ->orWhere('name->en', 'like', "%$search%")
            )
    
        )->when($this->request->has('type') && $this->request->filled('type') && $this->request->type == 'temp',
            fn($q) => $q->has('temp')
        )->when(
            $this->request->has('type') && $this->request->type == 'pending',
            fn($q) => $q->where('status',ProductStatus::PENDING)
        )->when(
            $this->request->has('is_active') && $this->request->is_active != 'all',
            fn($q) => $q->where('is_active',$this->request->is_active)
        )
        // ->when(
        //     $this->request->has('status') && $this->request->status != 'all',
        //     fn($q) => $q->where('is_active', $this->request->status == "active" ? 1 : 0)
        // )
        ->when(
            $this->request->has('created_date'),
            function ($q) {
                $dateRange = explode(" to " ,$this->request->created_date);
                if (count($dateRange) == 2) {
                    $dateFrom = Carbon::parse($dateRange[0])->format("Y-m-d");
                    $dateTo = Carbon::parse($dateRange[1])->format("Y-m-d");
                    $dateFrom = $dateFrom ." 00:00:00";
                    $dateTo = $dateTo ." 23:59:59";
                    $q->when(
                        $dateFrom && $dateTo,
                        fn($subQ) => $subQ->where('created_at', '>=', $dateFrom)->where('created_at', '<=', $dateTo)
                    );
                }
            }
        );
    }

    public function headings(): array
    {
        return [
            'معرف المنتج',
            'اسم المنتج بالعربي',
            'صوره المنتج',
            'القسم',
            'المتجر' ,
            'السعر' ,
            'كميه المنتج' ,
            'مرئي' ,
            'الحاله' ,
        ];
    }



    public function map($product): array
    {
        return [
            $product->id,
            $product->getTranslation('name', 'ar'),
            asset($product->image),
            $product->category->name,
            $product->vendor->name,
            $product->price,
            $product->stock,
            $product->is_visible == 1 ? 'نعم' : 'لا',
            $product->is_active == 1 ? 'مفعل' : 'غير مفعل',

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
            'B' => 30,
            'C' => 30,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'H' => 15,
            'H' => 15,


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
