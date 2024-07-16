<?php

namespace App\Exports;

use App\Models\OrderProcessRate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderProcessRateExport implements FromCollection,WithHeadings,WithMapping
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
            'الطلب الفرعي',
            'البائع',
            "طريقة الشحن",
            "التقييم",
            "متوسط التقييم",
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

        $shippingType = $item->shippingType->title;
        if($item->shipping_type_id == 1){
            $shippingType .= '('. $item->order->receiveOrderVendorWarehouse->warehouse->getTranslation('name','ar') .')';
        }elseif($item->shipping_type_id == 2){
            $shippingType .= '('. $item->order->orderShipping->transShippingMethodStatus() .')';
        }
        
        $clms = ['merchantInteraction','storeOrganization','productAvailability'];
        if($item->shipping_type_id == 2){
            $clms = ['orderArrivalSpeed','deliveryRepInteraction','productSafetyAfterDelivery','repResponseTime'];
        }
        
        $review= "";
        foreach ($clms as $clm){
            $review .= $item::CLMS_ARRAY[$clm] .'('. $item->$clm  . ")\n";
        }

        return [
            $item->transaction->customer->name  ?? NULL,
            $item->transaction->customer->phone  ?? NULL,
            $item->transaction->code  ?? NULL,
            $item->order->code  ?? NULL,
            $item->order->vendor->name  ?? NULL,
            $shippingType,
            $review,
            $item->avgRating(),
            $item->created_at,
        ];
       
    }
  
}
