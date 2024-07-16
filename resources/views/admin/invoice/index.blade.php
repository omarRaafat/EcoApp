@extends('admin.layouts.master')

@section('title')
    @lang('Invoice.label')
@endsection

@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            {{--                            @lang('Invoice.label')--}}
                        </h5>
                        <div class="flex-shrink-0">
                            @if (auth()->user()?->isAdminPermittedTo('admin.invoices.create'))
                                <div class="d-flex gap-1 flex-wrap">
                                    <a href="{{ route("admin.invoices.create") }}"
                                       class="btn btn-primary add-btn" id="create-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> @lang("Invoice.create.label")
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('Invoice.label')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="{{ URL::asset('/admin') }}/invoices/">
                        <!-- Col Form Label Default -->
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('vendor_name') }}" name="vendor_name" type="text"
                                           class="form-control search" placeholder="@lang('admin.vendor_name')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select name="year" class="form-control" data-choices data-choices-search-false
                                        name="choices-single-default" id="year">
                                    <option @if (request('year') == '') SELECTED @endif value="">
                                        @lang('Invoice.create.select_year')</option>
                                    @foreach(range(2020, now()->format("Y")) as $year)
                                        <option @if (request('year') == $year) SELECTED @endif value="{{$year}}">
                                            {{$year}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select name="month" class="form-control" data-choices data-choices-search-false
                                        name="choices-single-default" id="month">
                                    <option @if (request('month') == '') SELECTED @endif value="">
                                        @lang('Invoice.create.select_month')</option>
                                    @foreach(range(1, 12) as $month)
                                        <option @if (request('month') == $month) SELECTED @endif value="{{$month}}">
                                            {{$month}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('admin.vendor_name')</th>
                            <th scope="col">@lang('Invoice.attributes.period')</th>
                            <th scope="col">@lang('Invoice.attributes.total_without_vat')</th>
                            <th scope="col">@lang('Invoice.attributes.vat_amount')</th>
                            <th scope="col">@lang('Invoice.attributes.total_with_vat')</th>
                            <th scope="col">@lang('Invoice.attributes.status')</th>
                            <th scope="col">@lang('admin.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>
                                    <a href="{{route("admin.vendors.show", ["vendor" => $invoice->vendor_id])}}">{{ $invoice->vendor_data["name"]["ar"] }}</a>
                                </td>
                                <td>{{ $invoice->period_start_at->format("Y-m") }}</td>
                                <td>{{ $invoice->total_without_vat }}</td>
                                <td>{{ $invoice->vat_amount }}</td>
                                <td>{{ $invoice->total_with_vat }}</td>
                                <td><span
                                        class="badge badge-{{$invoice->status->badgeClass()}}">{{ $invoice->status->title() }}</span>
                                </td>
                                <td><a href="{{route('admin.invoices.export-pdf', ["invoice" => $invoice->id])}}"
                                       class="btn btn-info" target="_blank">
                                        @lang("Invoice.print.label")
                                    </a>
                                    <a href="{{ route('admin.invoices.show', ['invoice' => $invoice]) }}"
                                       class="btn btn-info" target="_blank">
                                        @lang("Invoice.view")
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
