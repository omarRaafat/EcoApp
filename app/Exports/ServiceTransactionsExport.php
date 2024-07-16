<?php

namespace App\Exports;

use App\Enums\PaymentMethods;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Pipeline\Pipeline;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ServiceTransactionsExport implements FromQuery, WithHeadings , WithMapping, WithColumnFormatting,WithColumnWidths,WithEvents
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
        $query = Transaction::select('transactions.*');
        // ->join('users', 'transactions.customer_id', '=', 'users.id');
        $query = app(Pipeline::class)
        ->send($query)
        ->through([
            \App\Pipelines\Admin\Transaction\FilterStatus::class,
            \App\Pipelines\Admin\Transaction\FilterCustomer::class,
            \App\Pipelines\Admin\Transaction\FilterCode::class,
            \App\Pipelines\Admin\Transaction\FilterDate::class,
            \App\Pipelines\Admin\Transaction\FilterTracking::class,
            \App\Pipelines\Admin\Transaction\FilterShippingMethod::class,
            \App\Pipelines\Admin\Transaction\FilterShippingType::class,
        ])
        ->thenReturn();

        return  $query->descOrder();

    }

    public function headings(): array
    {

        return [
            'كود الطلب',
            'العميل',
            'الجوال',
            'عدد الخدمات',
            'طريقة الدفع',
            'المبلغ المدفوع',
            'عدد البائعين' ,
            'المدينة',
            'تاريخ الطلب' ,
            'حالة الطلب',
       ];
    }



    public function map($transaction): array
    {
        return [
            $transaction->code,
            $transaction->customer_name,
            $transaction->customer?->phone ?? null,
            $transaction->products_count,
            PaymentMethods::getStatus($transaction->payment_method),
            $transaction->total .'  '. __('translation.sar'),
            $transaction->orderServices->count(),
            $transaction->city?->name,
            \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() ,
            $transaction->transStatus(),
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
