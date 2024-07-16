@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.PaymentMethods')
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
        <div class="card" id="reports">
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route("admin.reports.PaymentMethods") }}">
                    <div class="row g-3">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input type="date" name="from" class="form-control search" value="{{ request()->get('from') }}" >
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input type="date" name="to" class="form-control search" value="{{ request()->get('to') }}" >
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.reports.filter")
                                </button>
                            </div>
                        </div>
                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <a href="{{route('admin.reports.PaymentMethods')}}" class="btn btn-info w-100"><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.warehouses.reset")
                                </a>
                            </div>



                        </div>
                        <!--end col-->
                    <div class="col-xxl-1 col-sm-4">
                        <div>
                            <a href="{{ route('admin.reports.PaymentMethods' , ['export_excel'=>true, 'from' => request()->get('from') , 'to' => request()->get('to') ]) }}" class="btn btn-primary">Excel تصدير</a>
                        </div>
                    </div>
                    </div>
                    <!--end row-->
                </form>
{{--                <div class="col-md-3">--}}
{{--                    --}}{{-- <a class="btn-prinnt btn btn-info text-white btn-lg pt-1 mt-3" href=" ?action=print&date={{ request()->get('from') }}&date_to={{ request()->get('to') }}">طباعة <i class="text-white "></i></a> --}}
{{--                    <a class="btn-prinnt btn btn-info text-white btn-lg pt-1 mt-3" href="{{ route('admin.reports.PaymentMethods' , ['export'=>true, 'from' => request()->get('from') , 'to' => request()->get('to') ]) }}">export to excel <i class="text-white "></i></a>--}}
{{--                </div>--}}
            </div>
            <br>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="warehousesTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th># المعرف</th>
                                <th>الإسم</th>
                                <th>عدد طلبات</th>
                                <th> قيمة الطلبات </th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($results as $key =>$result)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->transaction_count }}</td>
                                        <td>{{ $result->total_value }}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        @if(empty($results))
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
                    </div>
                </div>
                <div>
                <!-- End Delete Modal -->
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
