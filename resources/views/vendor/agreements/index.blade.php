@extends('vendor.layouts.master')
@section('title')
    @lang('vendors.my-agreements')
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.app_name')
        @endslot
        @slot('title')
            @lang('vendors.my-agreements')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('vendors.my-agreements')</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.status')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.agreement-pdf')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.agreement-approved-pdf')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.approved-at')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($collection ?? [] as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ __('admin.vendors-agreements-keys.'. $row->status) }}</td>
                                <td>
                                    <a href="{{ $row->agreement_pdf }}" target="_blank">
                                        @lang('admin.vendors-agreements-keys.download') {{ $row->agreement_pdf_name }}
                                    </a>
                                </td>
                                <td>
                                    @if($row->approved_pdf)
                                        <a href="{{ $row->approved_pdf }}" target="_blank">
                                            @lang('admin.vendors-agreements-keys.download') {{ $row->approved_pdf_name }}
                                        </a>
                                    @else
                                        {{ __("admin.no_data") }}
                                    @endif
                                </td>
                                <td>{{ $row->approved_at?->format("Y-m-d H:s") ?? __("admin.no_data") }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $collection->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
