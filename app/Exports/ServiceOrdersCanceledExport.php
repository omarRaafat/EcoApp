<?php

namespace App\Exports;

use App\Enums\PaymentMethods;
use App\Models\Order;
use App\Models\OrderService;
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

class ServiceOrdersCanceledExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithEvents
{

    use Exportable;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    public function query()
    {
        $query = OrderService::where('status', 'canceled');
        if ($this->request->code != null && $this->request->code != '') {
            $query = $query->where('code', $this->request->code);
        }
        if ($this->request->customer != null && $this->request->customer != '') {
            $query = $query->where('customer_name', 'like', '%' . $this->request->customer . '%');
        }
        if ($this->request->dues != null && $this->request->dues == 'pending')
        {
            $query = $query->whereIn('refund_status', ['pending','no_found']);
        }
        elseif($this->request->dues != null && $this->request->dues != '') {
            $query = $query->where('refund_status', $this->request->dues);
        }
        return $query->descOrder();

    }

    public function headings(): array
    {

        return [
            ' كود الطلب الفرعي',
            ' العميل',
            ' الخدمات',
            ' طريقة الدفع',
            ' المبلغ المدفوع',
            ' المتجر',
            ' تاريخ الطلب',
            ' حالة الطلب',
            ' المستحقات',
        ];
    }


    public function map($transaction): array
    {

        $checkWallet = $transaction->wallet_amount;
        $checkVisa = $transaction->visa_amount;
        $paymentId = $transaction->payment_id ?? null;
        if ($checkWallet > 0 && $paymentId != 3)
            $paymentId = \App\Enums\PaymentMethods::getStatusList()[$paymentId] .'-'. \App\Enums\PaymentMethods::getStatus(3);
        else
            $paymentId = \App\Enums\PaymentMethods::getStatusList()[$paymentId];

        $dues = null;
        if ($transaction->refund_status == 'pending')
            $dues = 'معلق';
        elseif($transaction->refund_status == 'completed')
            $dues = 'تم ارجاع جميع المستحقات ';
        else
            $dues = ' معلق';

        // dd($transaction->code);
        return [
            $transaction->code,
            $transaction->customer_name,
            $transaction->num_services,
            $paymentId,
            $transaction->total . '  ' . __('translation.sar'),
            $transaction->vendor->name,
            \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString(),
            \App\Enums\ServiceOrderStatus::getStatus($transaction->status),
            $dues,


        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_TEXT,

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
