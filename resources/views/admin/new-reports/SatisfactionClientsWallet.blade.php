@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.SatisfactionClientsWallet')
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
                <form action="{{ route("admin.reports.SatisfactionClientsWallet") }}">
                    <div class="row g-3">

                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="from" type="date" class="form-control search"
                                       placeholder="@lang("admin.reports.search_barcode")" value="{{ request('from') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="to" type="date" class="form-control search"
                                       placeholder="@lang("admin.reports.search_barcode")" value="{{ request('to') }}">
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
                                <a href="{{route('admin.reports.products_quantity')}}" class="btn btn-info w-100"><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.warehouses.reset")
                                </a>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div>
                <a href="{{ route('admin.reports.SatisfactionClientsWallet' , ['export'=>true, 'from' => request()->get('from') , 'to' => request()->get('to') ]) }}" class="btn btn-primary">Export to Excel</a>
            </div>
            <br>
            <div class="card-body pt-0">
                <div>
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="warehousesTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>#ID </th>
                                <th>العميل</th>
                                <th> المبلغ</th>
                                <th>السبب  </th>
                                <th>بتاريخ</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($clientWallets as $key=> $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item['client_id'] }}</td>
                                        <td>{{ $item['amount'] }}</td>
                                        <td>{{ $item['details'] }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                <!-- End Delete Modal -->
                @if(empty($clientWallets))
                    <div class="noresult">
                        <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                           colors="primary:#25a0e2,secondary:#0ab39c"
                                           style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">@lang('admin.reports.no_result_found')</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                    {{-- @if ($clientWallets instanceof \Illuminate\Pagination\LengthAwarePaginator) --}}
                        {{-- {{ collect($clientWallets->link()}} --}}
                    {{-- @endif --}}
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


