@extends('admin.layouts.master')
@section('title')
    @lang('admin.transactionProcessRate.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" >
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action=" ">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-3">
                                <div class="search-box">
                                    <input value="{{ request('search') }}" name="search" type="text" class="form-control search" placeholder="الإسم, الجوال, رقم الطلب">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-3">
                                <div class="d-flex ">
                                    <input value="{{ request('avgRatingFrom') }}" name="avgRatingFrom" type="number" step="0.1" min="0.1" max="5" class="form-control " placeholder="متوسط التقييم من">
                                    <input value="{{ request('avgRatingTo') }}" name="avgRatingTo" type="number" step="0.1" min="0.1" max="5" class="form-control " placeholder="متوسط التقييم إلى">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('from') }}" name="from" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('to') }}" name="to" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
                                </div>
                            </div>

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i> تصفية
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{ route('admin.transactionProcessRate.index' , [
                                        'action' => 'exportExcel' ,
                                        'search' => request()->get('search') ,
                                         'from' => request()->get('from') ,
                                         'to' => request()->get('to') ,
                                         'avgRatingFrom' => request()->get('avgRatingFrom') ,
                                         'avgRatingTo' => request()->get('avgRatingTo') ,
                                         ]) }}" class="btn btn-sm btn-primary mt-2"> تصدير إكسل</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="transactionProcessRateTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>#</th>
                                    <th>العميل</th>
                                    <th>رقم الجوال</th>
                                    <th>الطلب الرئيسي</th>
                                    <th>سهولة وسرعة الوصول </th>
                                    <th>دقة وتوافق وحداثة المعلومات </th>
                                    <th>سرعة التصفح والتنقل</th>
                                    <th>الإستجابة للشكاوى والإستفسارات</th>
                                    <th>متوسط التقييم </th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach($rows as $rate)
                                        <tr>
                                            <td class="id">{{$rate->id}}</td>
                                            <td class="user_id"><small>{{ $rate->transaction->customer->name  ?? NULL }}</small></td>
                                            <td><small>{{ $rate->transaction->customer->phone  ?? NULL }}</small></td>
                                            <td>{{ $rate->transaction->code  ?? NULL }}</td>
                                            @foreach (['EaseSpeed','FreshnessInformation','EaseUse','ContactSupport'] as $clm)
                                                <td>
                                                    <div class="stars">
                                                        <i class="ri-star-fill {{ ($rate->$clm >= 5) ? 'text-warning' : '' }}"></i>
                                                        <i class="ri-star-fill {{ ($rate->$clm >= 4) ? 'text-warning' : '' }}"></i>
                                                        <i class="ri-star-fill {{ ($rate->$clm >= 3) ? 'text-warning' : '' }}"></i>
                                                        <i class="ri-star-fill {{ ($rate->$clm >= 2) ? 'text-warning' : '' }}"></i>
                                                        <i class="ri-star-fill {{ ($rate->$clm >= 1) ? 'text-warning' : '' }}"></i>
                                                    </div>
                                                </td>
                                            @endforeach
                                            <td>{{$rate->avgRating()}} </td>
                                            <td>
                                                <span>
                                                    {{ \Carbon\Carbon::parse($rate->created_at)->format("d-m-Y H:i") }}
                                                 </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.vendorRates.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $rows->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
