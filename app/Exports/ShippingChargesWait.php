<?php

namespace App\Exports;

use App\Enums\OrderShipStatus;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ShippingChargesWait implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, WithColumnWidths, WithEvents
{
    use Exportable;

    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders->get();
    }

    public function headings(): array
    {
        return [
            '# المعرف',
            'تكلفة الشحنة',
            'وزن الشحنة',
            'حالة الشحنة',
            'طريقة الشحن',
            'أسم البائع',
            'رقم الطلب',
            'رقم البوليصة',
            'تاريخ الطلب',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->orderShipping->total_shipping_fees,
            $order->orderShipping->total_weight ? $order->orderShipping->total_weight . ' كيلو جرام ' : 0,
            isset($order->orderShip->status) ? OrderShipStatus::getStatus($order->orderShip->status) : 'قيد التجهيز',
            $order->orderShipping->shipping_method_id == 1 ? 'أرامكس' : 'سبل',
            $order->vendor->name,
            $order->code,
            $this->getTrackID($order),
            date('d-m-Y, H:i', strtotime($order->created_at)),
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
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 50,
            'I' => 50,

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
     * @param Order $order
     * @return string|void
     */
    public function getTrackID(Order $order)
    {
        if ($order->orderShipping->shipping_method_id == 1) {
            if ($order->orderShip?->gateway_tracking_id)
                return env('ARAMEX_TRACKING_URL') . $order->orderShip?->gateway_tracking_id;
            else
                return 'لا يوجد';
        } elseif ($order->orderShipping->shipping_method_id == 2) {
            if ($order->orderShip?->gateway_tracking_id)
                return env('SPL_TRACKING_URL') . $order->orderShip?->gateway_tracking_id;
            else
                return 'لا يوجد';
        }

    }
}
