<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransactionProcessRate;
use App\Exports\TransactionProcessRateExport;
use Excel;

class TransactionProcessRateController extends Controller
{
    public function index(Request $request){
        $rows = TransactionProcessRate::with('transaction.customer')->filterSearch()->filterPeriod()->filterAvgRating()->latest();
        if($request->action == "exportExcel"){
            $filename = date('Ymd_H').'_TransactionProcessRates.xlsx';
            return Excel::download(new TransactionProcessRateExport($rows->get()), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
        $rows = $rows->paginate(50);
        return view("admin.transactionProcessRate.index", compact('rows'));
    }
}
