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

class VendorOrdersExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithEvents
{

    use Exportable;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    public function query()
    {
       
        $query = Order::where('vendor_id' , auth()->user()->vendor_id)->where('status','!=',OrderStatus::WAITINGPAY);
       
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
        if ($this->request->date_from && $this->request->date_from != '' && $this->request->date_to && $this->request->date_to != '')
        {
            $query =   $query->whereDate('orders.created_at','>=' ,$this->request->date_from )->whereDate('orders.created_at','<=' ,$this->request->date_to);
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

        if ($this->request->shipping_method && $this->request->shipping_method != '')
        {
            $search = $this->request->shipping_method;
            $query->whereHas('orderVendorShippings', function($q) use($search){
                $q->where('shipping_method_id' , $search);

            });
        }

        if ($this->request->track_id && $this->request->track_id != '')
        {
            $search_track = $this->request->track_id;
            $query->whereHas('orderShip', function($q) use($search_track){
                $q->where('gateway_tracking_id' , $search_track);
            });
        }
        return $query->descOrder();

    }

    public function headings(): array
    {

        return [
            ' كود الطلب 	',
            ' العميل',
            ' المنتجات',
            ' طريقة الدفع	',
            ' الشحن الي	',
            ' تاريخ الطلب	',
            ' حالة الطلب	',
            ' نوع الشحن	',
            ' نوع التوصيل	',
            ' متابعة الطلب',

        ];
    }


    public function map($transaction): array
    {

        $checkWallet = $transaction->wallet_amount;
        $checkVisa = $transaction->visa_amount;
        $paymentId = $transaction->payment_id ?? null;
        // if ($checkWallet > 0 && $paymentId != 3)
        //     $paymentId = \App\Enums\PaymentMethods::getStatusList()[$paymentId] .'-'. \App\Enums\PaymentMethods::getStatus(3);
        // else
        //     $paymentId = \App\Enums\PaymentMethods::getStatusList()[$paymentId];

        $dues = null;
        if ($transaction->refund_status == 'pending')
            $dues = 'معلق';
        elseif($transaction->refund_status == 'completed')
            $dues = 'تم ارجاع جميع المستحقات ';
        else
            $dues = 'لا معلق';

        // dd($transaction->code);
        return [
            $transaction->transaction->code,
            $transaction->customer_name,
            $transaction->num_products,
            $paymentId,
            $transaction->orderVendorShippings[0]->to_city_name?? trans("admin.not_found"),
            \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString(),
            \App\Enums\OrderStatus::getStatus($transaction->status),
            $this->getShippingMethod($transaction),
            $this->getShippingType($transaction),
            $this->getTrackings($transaction),


        ];
    }

    public function getTrackings($transaction){
        $shippings = [];
        foreach($transaction->orderVendorShippings()->where('shipping_type_id' , 2)->get() as $trans){

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
    public function getShippingType($transaction)
    {
        $shippings = [];
        foreach ($transaction->orderVendorShippings()->get()->unique('shipping_type_id')->pluck('shipping_type_id') as $trans) {
            if ($trans == 1) {
                $shippings[] = 'استلام';
            } elseif ($trans == 2) {
                $shippings[] = 'توصيل';
            }
        }

        return implode(' - ', $shippings);
    }

    public function getShippingMethod($transaction)
    {
        $shippings = [];
        foreach ($transaction->orderVendorShippings()->get()->unique('shipping_method_id')->pluck('shipping_method_id') as $trans) {

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
