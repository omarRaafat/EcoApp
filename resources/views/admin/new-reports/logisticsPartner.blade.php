@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.product_quantity')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('sweetalert::alert')
@if(session()->has('error'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger">{{ session("error") }}</div>
        </div>
    </div>
@endif


@section('styles')
    <style>
        .dt-buttons{
            text-align: left;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
<div class="container" style="">
    <div class="showdata">

     <br>
     <div class="">
        {{-- <form class="row text-right" action="{{ route('dash.'.$route) }}" method="GET" id="formsearch">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <label>من تاريخ</label>
                <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}" >
            </div>
            <div class="col-md-3">
                <label>إلى تاريخ</label>
                <input type="date" name="date_to" class="form-control" value="{{ request()->get('date_to') }}" >
            </div>
             <div class="col-md-2">
               <button type="submit" class="btn btn-success mt-4" style="width: 100%">بحث</button>
            </div>
            <div class="col-md-1 text-left">
                <a class="btn-prinnt btn btn-info text-white btn-sm pt-1" href=" ?action=print&date={{ request()->get('date') }}&date_to={{ request()->get('date_to') }}">طباعة <i class="fas fa-file-pdf text-white "></i></a>
            </div>
        </form> --}}

        <br>
        <table class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                 <th>Aramex</th>
                <th>عدد طلبات</th>
                <th>القيمة شاملة الضريبة </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $clm1 = 0;
                @endphp
                <tr>
                    <td>التوصيل مدن رئيسية</td>
                    @php 
                    $orders = \App\Models\CartVendorEarn::where('shipping_price','>',0)->orderBy('id','asc');
                    if(request()->get('date') != null && request()->get('date') != ''){
                        $orders = $orders->whereDate('created_at','>=',request()->get('date'));
                    }

                    if(request()->get('date_to') != null && request()->get('date_to') != ''){
                        $orders = $orders->whereDate('created_at','<=',request()->get('date_to'));
                    }
                    $orders = $orders->get();

                    $val_orders = 0;
                    $count= 0;
                    foreach ($orders as $key => $value) {
                         
                                $val_orders += $value->shipping_price;
                                $count += 1;
                            
                    }

                    $clm1 += $val_orders;
                    @endphp
                    <td>{{ $count }}</td>
                    <td>{{  number_format($val_orders,2,'.','') }}</td>
                </tr>
                <tr>
                    <td>الإجمالي</td>
                    <td>{{ $count }}</td>
                    <td>{{  number_format($clm1,2,'.','') }}</td>
                </tr>
            </tbody>
        </table>

       
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المبالغ المستحقة للمنصة</th>
                    <th>المستحق لشركة التوصيل</th>
                    <th>الصافي</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @php 
                    $val_COD =0;
                    @endphp
                    <td>{{ number_format($val_COD,2,'.','') }}</td>
                    <td>{{ number_format($clm1,2,'.','') }}</td>
                    <td>{{ number_format($val_COD - $clm1,2,'.','') }}</td>
                </tr>
            </tbody>
        </table>
     </div>

  

 </div>

</div>


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
