@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.vendors_earnings')
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

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wallets">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form method="get" action="{{ URL::asset('/admin') }}/reports/vendors_earnings/">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-4">
                                    <select name="vendor" class="form-select" dir="rtl" data-choices data-choices-removeItem >
                                        <option value="">@lang('reports.select-vendor')</option>
                                        @foreach($vendors ?? [] as $vendor)
                                            <option value='{{ $vendor['id'] }}' @selected($vendor['id'] == request()->get('vendor'))> {{ $vendor['name'] }} </option>
                                        @endforeach
                                    </select>
                                    </div>
                                <div class="col-xxl-3 col-sm-4">
                                    <div>
                                        <input value="{{ request('from') }}" name="from" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-4">
                                    <div>
                                        <input value="{{ request('to') }}" name="to" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
                                    </div>
                                </div>

                                <div class="col-xxl-1 col-sm-4">
                                    <div>
                                        <button type="submit" class="btn btn-secondary w-100">
                                            <i class="ri-equalizer-fill me-1 align-bottom"></i> تصفية
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-sm-4">
                                    <div>
                                        <a href="{{ route('admin.reports.vendors_earnings' , [
                                         'from' => request()->get('from') ,
                                         'to' => request()->get('to') ,
                                         'vendor' => request()->get('vendor') ,
                                         'all_export_excel'=>true
                                         ]) }}" class="btn btn-primary"> تصدير Excel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body ">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="warehousesTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th># المعرف</th>
                                    <th>اسم المنشأة (كما في السجل التجاري)</th>
                                    <th>اسم المستفيد</th>
                                    <th> الاسم المسجل في البنك </th>
                                    <th>رقم حساب المستفيد</th>
                                    <th>بنك المستفيد</th>
                                    <th>المبلغ بالريال</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($vendors as $key=> $vendor)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $vendor->owner->name }}</td>
                                        <td>{{ $vendor->name }}</td>
                                        <td>{{ $vendor->name_in_bank }}</td>
                                        <td>{{ $vendor->ipan }}</td>
                                        <td>{{ $vendor->bank->swift_code }}</td>
                                        <td>{{ round(($vendor->vendorWalletTransactionIn - $vendor->vendorWalletTransactionOut),2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($vendors->isEmpty())
                                <div class="noresult">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                   colors="primary:#25a0e2,secondary:#0ab39c"
                                                   style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">@lang('admin.reports.no_result_found')</h5>
                                    </div>
                                </div>
                            @endif
                            {{ $vendors->appends(request()->except('page'))->links('pagination.default') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
