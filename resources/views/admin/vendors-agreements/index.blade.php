@extends('admin.layouts.master')
@section('title')
    @lang('admin.vendors-agreements')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-row justify-content-end">
                <a class="btn btn-primary" href="{{ route('admin.vendors-agreements.send-form') }}">@lang('admin.send-vendor-agreement')</a>
            </div>
            @if(session()->has("error"))
                <div class="alert alert-danger mt-3"> {{ session()->get("error") }} </div>
            @endif
            @if(session()->has("success"))
                <div class="alert alert-success mt-3"> {{ session()->get("success") }} </div>
            @endif
            <div class="card mt-3">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <select name="vendor" class="form-control" data-choices data-choices-search-true>
                                    <option value=""> @lang("admin.vendors-agreements-keys.select-vendor") </option>
                                    @foreach($vendors ?? [] as $vendor)
                                        <option value="{{ $vendor->id }}" @selected($vendor->id == request()->get('vendor'))>
                                            {{ $vendor->getTranslation("name", "ar") }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <select name="status" class="form-control" data-choices data-choices-search-false name="choices-single-default">
                                    <option value=""> @lang("admin.vendors-agreements-keys.select-status") </option>
                                    @foreach($statuses ?? [] as $key => $value)
                                        <option value="{{ $key }}" @selected($key == request()->get('status'))>
                                            {{ $value }}
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
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.vendor-name')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.status')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.agreement-pdf')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.agreement-approved-pdf')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.approved-at')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.approved-by')</th>
                            <th scope="col">@lang('admin.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($collection ?? [] as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->vendor?->getTranslation("name", "ar") }}</td>
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
                                <td>{{ $row->approvedBy?->name ?? __("admin.no_data") }}</td>
                                <td>
                                    @if($row->status == \App\Enums\VendorAgreementEnum::PENDING)
                                        <form method="POST" action="{{ route("admin.vendors-agreements.cancel", ['agreement' => $row]) }}">
                                            @csrf
                                            @method("PUT")
                                            <button class="btn btn-danger" title="@lang('admin.vendors-agreements-keys.cancel-agreement')">
                                                <i class="ri-forbid-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($row->status == \App\Enums\VendorAgreementEnum::CANCELED)
                                        <form method="POST" action="{{ route("admin.vendors-agreements.resend", ['agreement' => $row]) }}">
                                            @csrf
                                            @method("PUT")
                                            <button class="btn btn-info" title="@lang('admin.vendors-agreements-keys.resend-agreement')">
                                                <i class="ri-send-backward"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
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
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@section('script-bottom')
    <script>
    </script>
@endsection
