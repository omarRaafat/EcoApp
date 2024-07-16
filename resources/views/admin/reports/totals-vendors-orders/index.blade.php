@extends('admin.layouts.master')
@section('title')
    @lang('reports.total-vendors-orders.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <select name="vendor" class="form-select" dir="rtl" data-choices data-choices-removeItem>
                                        <option value="">@lang('reports.select-vendor')</option>
                                        @foreach($vendors ?? [] as $vendor)
                                            <option value='{{ $vendor['id'] }}' @selected($vendor['id'] == request()->get('vendor'))> {{ $vendor['name'] }} </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" id="vendor-id-error" role="alert">
                                        <strong> @lang("admin.required") </strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="from" type="text" class="form-control flatpickr-input active" value="{{ request()->get('from') }}"
                                           data-provider="flatpickr" data-date-format="Y-m-d"
                                           placeholder="@lang('reports.date-from')">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="to" type="text" class="form-control flatpickr-input active" value="{{ request()->get('to') }}"
                                           data-provider="flatpickr" data-date-format="Y-m-d"
                                           placeholder="@lang('reports.date-to')">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-search-line search-icon"></i>
                                        @lang("translation.search")
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
            @if(session()->has('error'))
                <div class="alert alert-danger"> {{ session('error') }} </div>
            @endif
            <div class="card mt-5">
                <div class="card-body d-flex flex-column gap-4">
                    <div>
                        <button type="button" onclick="openExcel()" class="btn btn-success"> @lang('reports.excel') </button>
                        <button type="button" onclick="openPrint()" class="btn btn-info"> @lang('reports.print') </button>
                    </div>
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('reports.total-vendors-orders.vendor')</th>
                                    <th>@lang('reports.total-vendors-orders.total-without-vat')</th>
                                    <th>@lang('reports.total-vendors-orders.vat-rate')</th>
                                    <th>@lang('reports.total-vendors-orders.total-with-vat')</th>
                                    <th>@lang('reports.total-vendors-orders.company-profit-without-vat')</th>
                                    <th>@lang('reports.total-vendors-orders.company-profit-vat-rate')</th>
                                    <th>@lang('reports.total-vendors-orders.company-profit-with-vat')</th>
                                    <th>@lang('reports.total-vendors-orders.vendor-amount')</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($collection ?? [] as $row)
                                    @include("admin.reports.totals-vendors-orders.row", ['row' => $row, 'noPrint' => false])
                                @endforeach
                                @if($collection->isEmpty())
                                    <tr>
                                        <td colspan = "11">
                                            <center>
                                                @lang('reports.total-vendors-orders.no-orders')
                                            </center>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                @if($collection instanceof Illuminate\Contracts\Pagination\LengthAwarePaginator)
                                    {{ $collection->appends(request()->query()) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    @include("admin.reports.footer-totals")
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        function openPrint() {
            const vendor = $("select[name=vendor]").val()
            const from = $("input[name=from]").val()
            const to = $("input[name=to]").val()
            window.open(`{{ route('admin.reports.total-vendors-orders.print') }}?vendor=${vendor}&from=${from}&to=${to}`, "_blank")
        }

        function openExcel() {
            const vendor = $("select[name=vendor]").val()
            const from = $("input[name=from]").val()
            const to = $("input[name=to]").val()
            window.open(`{{ route('admin.reports.total-vendors-orders.excel') }}?vendor=${vendor}&from=${from}&to=${to}`, "_blank")
        }
    </script>
@endsection
