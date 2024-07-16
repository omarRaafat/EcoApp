<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderProcessRate;
use App\Exports\OrderProcessRateExport;
use Excel;


class OrderProcessRateController extends Controller
{
    public function index(Request $request){
        $rows = OrderProcessRate::with(['transaction.customer','order.vendor','order.receiveOrderVendorWarehouse'])
            ->filterSearch()->filterPeriod()->filterAvgRating()->filterShippingTypeId()->latest();
        if($request->action == "exportExcel"){
            $filename = date('Ymd_H').'OrderProcessRates.xlsx';
            return Excel::download(new OrderProcessRateExport($rows->get()), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
        $rows = $rows->paginate(50);
        return view("admin.orderProcessRate.index", compact('rows'));
    }
}
