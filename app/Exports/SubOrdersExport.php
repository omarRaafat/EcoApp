<?php

namespace App\Exports;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SubOrdersExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithEvents
{

    use Exportable;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    public function query()
    {
        $query = Order::with(['orderVendorShippings', 'vendor', 'transaction','orderNote'])->where('status','!=',OrderStatus::WAITINGPAY);
        if ($this->request->shipping_method != null && $this->request->shipping_method != '') {
            $query = $query->where('delivery_type', $this->request->shipping_method);
        }
        if ($this->request->code != null && $this->request->code != '') {
            $query = $query->where(function($qr){
                $qr->where('code', request()->get('code'))->orWhereHas('transaction', function($qrTransaction){
                    $qrTransaction->where('code', request()->get('code'));
                });
            });
        }
        if ($this->request->customer != null && $this->request->customer != '') {
            $query = $query->where('customer_name', 'like', '%' . $this->request->customer . '%');
        }
        if ($this->request->dues != null && $this->request->dues != '') {
            $query = $query->where('refund_status', $this->request->dues);
        }
        if ($this->request->from && $this->request->from != '' && $this->request->to && $this->request->to != '')
        {
            $query =   $query->whereDate('orders.created_at','>=' ,$this->request->from )->whereDate('orders.created_at','<=' ,$this->request->to);
        }
        if ($this->request->status != null && $this->request->status != '') {
            $query = $query->where('status', $this->request->status);
        }
        if ($this->request->shipping_type && $this->request->shipping_type != '')
        {
            $search = $this->request->shipping_type;
            $query->whereHas('orderVendorShippings', function($q) use($search){
                $q->where('shipping_type_id' , $search);

            });
        }

        if ($this->request->gateway_tracking_id && $this->request->gateway_tracking_id != '')
        {
            $search_track = $this->request->gateway_tracking_id;
            $query->whereHas('orderShip', function($q) use($search_track){
                $q->where('gateway_tracking_id' , $search_track);
            });
        }
        return $query->descOrder();

    }

    public function headings(): array
    {

        return [
            'كود الطلب الرئيسي',
            'كود الطلب الفرعي',
            'العميل',
            'المنتجات',
            'طريقة الدفع',
            'المبلغ المدفوع',
            'المتجر',
            'الشحن الي',
            'تاريخ الطلب',
            'حالة الطلب',
            'نوع الشحن	',
            'نوع التوصيل',
            'ملاحظة البائع',
            'متابعة الطلب',

        ];
    }


    public function map($order): array
    {

        $checkWallet = $order->wallet_amount;
        $checkVisa = $order->visa_amount;
        $paymentId = $order->payment_id ?? null;
        if ($checkWallet > 0 && $paymentId != 3)
            $paymentId = \App\Enums\PaymentMethods::getStatusList()[$paymentId] .'-'. \App\Enums\PaymentMethods::getStatus(3);
        else
            $paymentId = \App\Enums\PaymentMethods::getStatusList()[$paymentId];

        $dues = null;
        if ($order->refund_status == 'pending')
            $dues = 'معلق';
        elseif($order->refund_status == 'completed')
            $dues = 'تم ارجاع جميع المستحقات ';
        else
            $dues = 'لا معلق';

        // dd($order->code);
        return [
            $order->transaction->code??null,
            $order->code,
            $order->customer_name,
            $order->num_products,
            $paymentId,
            $order->total . '  ' . __('translation.sar'),
            $order->vendor->name,
            $order->orderVendorShippings[0]->to_city_name?? trans("admin.not_found"),
            \Carbon\Carbon::parse($order->created_at)->toFormattedDateString(),
            \App\Enums\OrderStatus::getStatus($order->status),
            $this->getShippingMethod($order),
            $this->getShippingType($order),
            $order->orderNote->note,
            $this->getTrackings($order),


        ];
    }

    public function getTrackings($order){
        $shippings = [];
        foreach($order->orderVendorShippings->where('shipping_type_id' , 2) as $trans){

            if(!empty($trans->order->orderShip?->gateway_tracking_id)){

                if($trans->shipping_method_id == 1){
                    $shippings[] =  env('ARAMEX_TRACKING_URL') . $trans->order->orderShip?->gateway_tracking_id  ;
                }else{
                    $shippings[] = env('SPL_TRACKING_URL') . $trans->order->orderShip?->gateway_tracking_id ;
                }
            }else{
                $shippings[] = "لا يوجد" ;
            }

        }
        return implode(' - ' ,$shippings );
    }
    public function getShippingType($order)
    {
        $shippings = [];
        foreach ($order->orderVendorShippings->unique('shipping_type_id')->pluck('shipping_type_id') as $trans) {
            if ($trans == 1) {
                $shippings[] = 'استلام';
            } elseif ($trans == 2) {
                $shippings[] = 'توصيل';
            }
        }

        return implode(' - ', $shippings);
    }

    public function getShippingMethod($order)
    {
        $shippings = [];
        foreach ($order->orderVendorShippings->unique('shipping_method_id')->pluck('shipping_method_id') as $trans) {

            if ($trans == 1) {
                $shippings[] = 'أرامكس';
            } elseif ($trans == 2) {
                $shippings[] = 'سبل';
            } else {
                $shippings[] = ' استلام بنفسي';
            }
        }

        return implode(' - ', $shippings);
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_NUMBER,

        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 10,
            'C' => 10,
            'D' => 10,
            'E' => 10,
            'F' => 10,
            'G' => 10,
            'H' => 20,

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
