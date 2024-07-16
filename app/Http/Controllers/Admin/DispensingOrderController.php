<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\DispensingOrder;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\VendorBankTransfer;
use App\Models\VendorWalletTransaction;
use App\Services\Alinma;
use App\Services\Admin\VendorWalletService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Eportal\Connection;


class DispensingOrderController extends Controller
{
    public $service;

    public function __construct(VendorWalletService $service) {
        $this->service = $service;
    }

    public function index(Request $request) : View
    {
        $validated = $request->validate([
            'from'    => 'nullable|date',
            'to'      => 'nullable|date|after_or_equal:from',
        ]);
        $orders = $this->indexFetchData($request);

        return view("admin.dispendingOrder.index", get_defined_vars());
    }

    public function store(Request $request)
    {
        $orders = $this->storeFetchData($request);

        if($orders->count() > 0)
        {
            foreach($orders as $order){
                DispensingOrder::query()->create([
                    'vendor_id' => $order->vendor_id,
                    'order_id'  => $order->id,
                    'amount'    => $order->vendor_amount,
                    'type'      => 'initial',
                    'initial_admin_id'      => auth()->user()->id,
                ]);
            }

            Alert::success('نجاح', 'تم تحويل الطلب إلى الأعتماد الأولى بنجاح');

        }else{
            Alert::error('خطأ', 'لا ييوجد بيانات للتحويل');
        }

        return back();
    }


    public function initialDispensingOrder(Request $request){

        $vendor = $request->get('vendor', null);

        $dispensingOrders = DispensingOrder::query()
            ->select('*', DB::raw('SUM(amount) as total_amount'))
            ->where('type' , 'initial')
            ->with(["vendor", "vendor.owner"])
            ->newQuery()
            ->when(
                $vendor,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->whereHas(
                        'vendor.owner',
                        fn($ownerQ) => $ownerQ->where('name', 'LIKE', "%$vendor%")
                    )
                        ->orWhereHas(
                            'vendor',
                            fn($vendorQ) => $vendorQ->where(
                                fn ($_q) => $_q->where('name->ar', 'LIKE', "%$vendor%")->orWhere('name->en', 'LIKE', "%$vendor%")
                            )
                        )
                )
            )
            ->groupBy('vendor_id')
            ->paginate(10);

        return view("admin.dispendingOrder.initial_index", get_defined_vars());

    }
    public function finalDispensingOrder(Request $request){
        $vendor = $request->get('vendor', null);

        $dispensingOrders = DispensingOrder::query()
            ->select('*', DB::raw('SUM(amount) as total_amount'))
            ->where('type' , 'final')
            ->with(["vendor", "vendor.owner"])
            ->newQuery()
            ->when(
                $vendor,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->whereHas(
                        'vendor.owner',
                        fn($ownerQ) => $ownerQ->where('name', 'LIKE', "%$vendor%")
                    )
                        ->orWhereHas(
                            'vendor',
                            fn($vendorQ) => $vendorQ->where(
                                fn ($_q) => $_q->where('name->ar', 'LIKE', "%$vendor%")->orWhere('name->en', 'LIKE', "%$vendor%")
                            )
                        )
                )
            )
            ->groupBy('vendor_id')
            ->paginate(10);
                                // dd('www');
        return view("admin.dispendingOrder.final_index", get_defined_vars());

    }

    public function changeInitialDispensingOrder(Request $request)
    {
        $vendor = $request->vendor;

        $dispensingOrders = DispensingOrder::query()
            ->where('type' , 'initial')
            ->with(["vendor", "vendor.owner"])
            ->newQuery()
            ->when(
                $vendor,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->whereHas(
                        'vendor.owner',
                        fn($ownerQ) => $ownerQ->where('name', 'LIKE', "%$vendor%")
                    )
                        ->orWhereHas(
                            'vendor',
                            fn($vendorQ) => $vendorQ->where(
                                fn ($_q) => $_q->where('name->ar', 'LIKE', "%$vendor%")->orWhere('name->en', 'LIKE', "%$vendor%")
                            )
                        )
                )
            )
            ->get();

        if($dispensingOrders->count() > 0)
        {
            foreach($dispensingOrders as $init){
                $init->update([
                    'type' => 'final',
                ]);
            }

            Alert::success('نجاح', 'تم تحويل الطلب إلى الأعتماد النهائى بنجاح');
        }else{

            Alert::error('خطأ', 'لا ييوجد بيانات للتحويل');
        }


        return back();

    }
    public function changefinalDispensingOrder(Request $request)
    {
        $vendor = $request->get('vendor', null);

        try{
            DB::beginTransaction();
            $dispensingOrders = DispensingOrder::query()
                ->where('type' , 'final')
                ->with(["vendor", "vendor.owner"])
                ->newQuery()
                ->when(
                    $vendor,
                    fn($q) => $q->where(
                        fn($subQ) => $subQ->whereHas(
                            'vendor.owner',
                            fn($ownerQ) => $ownerQ->where('name', 'LIKE', "%$vendor%")
                        )
                            ->orWhereHas(
                                'vendor',
                                fn($vendorQ) => $vendorQ->where(
                                    fn ($_q) => $_q->where('name->ar', 'LIKE', "%$vendor%")->orWhere('name->en', 'LIKE', "%$vendor%")
                                )
                            )
                    )
                )
                ->get();

            if($dispensingOrders->count() > 0) {
                // get center account info from eportal
                $centerAcoount = Connection::getCenterAccount();

                // will transfer into vendor iban
                $dataTransfer = $this->prepareDataTransfer($request);
                foreach($dataTransfer as $transfer){
                    $vendor = Vendor::query()->findOrFail($transfer->vendor_id);

                    $request_id = mt_rand(100000,999999);
                    $res = Alinma::transfer($centerAcoount['data']['account_name'] , $transfer->total_amount , $centerAcoount['data']['iban'] , $vendor->ipan , $request_id);
                    VendorBankTransfer::query()->updateOrCreate([
                        'FTRefNum' => $res['b2b:FundTransferRs']['alin:FTRefNum'],
                    ],[
                        'currency_id' => 1,
                        'vendor_id'   => $vendor->id,
                        'AmtDebitedAmount' => $res['b2b:FundTransferRs']['alin:AmtDebited']['alin:Amt'],
                        'AmtCreditedAmount' => $res['b2b:FundTransferRs']['alin:AmtCredited']['alin:Amt'],
                        'CurrBal' => $res['b2b:FundTransferRs']['alin:CurrBal'],
                        'request_id' => $request_id,
                        'type' => 'deposite',
                        'status' => 'success',
                    ]);
                }

                foreach($dispensingOrders as $init){

                    // Withdraw from wallet
                    VendorWalletTransaction::withdraw(
                        Order::query()->find($init->order_id),
                        auth()->user()->id
                    );

                    // change type in dispensingOrders
                    $init->update([
                        'type' => 'done',
                    ]);
                }

                Alert::success('نجاح', 'تم تحويل المبالغ بنجاح');
            }else{
                Alert::error('خطأ', 'لا ييوجد بيانات للتحويل');
            }

            DB::commit();

        }catch(\Exception $ex){
            DB::rollback();
            Alert::error('خطأ', $ex->getMessage());
        }


        return back();

    }


    private function indexFetchData(Request $request)
    {

        $vendor = $request->get('vendor', null);
        $from   = $request->get('from', null);
        $to     = $request->get('to', null);

        $orders = Order::query()
            ->select('*', DB::raw('SUM(vendor_amount) as total_amount'))
            ->when($from , function($q) use ($from){
                $q->whereDate('delivered_at','>=',$from);
            })->when($to , function($q) use ($to) {
                $q->whereDate('delivered_at', '<=', $to);
            })
            ->with(["vendor", "vendor.owner"])
            ->whereDoesntHave('dispensingOrder')
            ->newQuery()
            ->when(
                $vendor,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->whereHas(
                        'vendor.owner',
                        fn($ownerQ) => $ownerQ->where('name', 'LIKE', "%$vendor%")
                    )
                        ->orWhereHas(
                            'vendor',
                            fn($vendorQ) => $vendorQ->where(
                                fn ($_q) => $_q->where('name->ar', 'LIKE', "%$vendor%")->orWhere('name->en', 'LIKE', "%$vendor%")
                            )
                        )
                )
            )
            ->groupBy('vendor_id')
            ->where('status' , OrderStatus::COMPLETED)
            ->paginate(10);

        return $orders;
    }
    private function storeFetchData(Request $request)
    {
        $vendor = $request->get('vendor', null);
        $from   = $request->get('from', null);
        $to     = $request->get('to', null);

        $orders = Order::query()
            ->when($from , function($q) use ($from){
                $q->whereDate('delivered_at','>=',$from);
            })->when($to , function($q) use ($to) {
                $q->whereDate('delivered_at', '<=', $to);
            })
            ->with(["vendor", "vendor.owner"])
            ->newQuery()
            ->when(
                $vendor,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->whereHas(
                        'vendor.owner',
                        fn($ownerQ) => $ownerQ->where('name', 'LIKE', "%$vendor%")
                    )
                        ->orWhereHas(
                            'vendor',
                            fn($vendorQ) => $vendorQ->where(
                                fn ($_q) => $_q->where('name->ar', 'LIKE', "%$vendor%")->orWhere('name->en', 'LIKE', "%$vendor%")
                            )
                        )
                )
            )
            ->whereDoesntHave('dispensingOrder')
            ->where('status' , OrderStatus::COMPLETED)
            ->get();


        return $orders;
    }


    private function prepareDataTransfer(Request $request)
    {
        $vendor = $request->get('vendor', null);

        $dispensingOrders = DispensingOrder::query()
            ->select('vendor_id', DB::raw('SUM(amount) as total_amount'))
            ->where('type' , 'final')
            ->with(["vendor", "vendor.owner"])
            ->newQuery()
            ->when(
                $vendor,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->whereHas(
                        'vendor.owner',
                        fn($ownerQ) => $ownerQ->where('name', 'LIKE', "%$vendor%")
                    )
                        ->orWhereHas(
                            'vendor',
                            fn($vendorQ) => $vendorQ->where(
                                fn ($_q) => $_q->where('name->ar', 'LIKE', "%$vendor%")->orWhere('name->en', 'LIKE', "%$vendor%")
                            )
                        )
                )
            )
            ->get();

        return $dispensingOrders;

    }
}
