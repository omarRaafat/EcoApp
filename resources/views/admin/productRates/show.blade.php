@extends('admin.layouts.master')
@section('title')
    @lang("admin.productRates.show")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.productRates.show"): {{ $productRate->product->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-5">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.id")</b> {{ $productRate->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.product_id")</b> {{ $productRate->product->name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.rate")</b>
                            <i class="fas fa-star {{ ($productRate->rate >= 1) ? 'clr_yellow' : '' }}"></i>
                            ({{$productRate->rate}})
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.user_id")</b> {{  $productRate?->client->name ?? trans("admin.no_data") }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.comment")</b> {{ $productRate->comment ?? trans("admin.no_data") }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.reason")</b> {{ $productRate->reason ?? trans("admin.no_data") }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.admin_id")</b> {{ $productRate?->admin?->name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.admin_comment")</b> {{ $productRate->admin_comment ?? trans("admin.no_data") }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.admin_approved")</b>
                            <span class="{{ \App\Enums\AdminApprovedState::getStateWithClass($productRate->admin_approved)["class"] }}">
                                {{ \App\Enums\AdminApprovedState::getStateWithClass($productRate->admin_approved)["name"] }}
                            </span>
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.reporting")</b> {{ $productRate->reporting ?? trans("admin.no_data") }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.productRates.last_admin_edit")</b> {{ $productRate?->updated_at?->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.productRates.manage_productRates"):
                </h5>
            </div>
        </div>
    </div>
    <br>
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.productRates.update', $productRate->id) }}" method="post" class="form-steps" autocomplete="on">
                            @csrf
                            @method('PUT')
                            <div class="text-center pt-3 pb-4 mb-1">
                                <img src="assets/images/logo-dark.png" alt="" height="17">
                            </div>
                            <div class="tab-content">
                                <!-- Start Of Arabic Info tab pane -->
                                <div class="tab-pane fade active show" id="productRates-arabic-info" role="tabpanel"
                                    aria-labelledby="productRates-arabic-info-tab">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="admin_comment">@lang('admin.productRates.admin_comment')</label>
                                                    <textarea name="admin_comment" id="admin_comment"
                                                        class="form-control" cols="30" rows="10"
                                                        placeholder="{{ trans('admin.productRates.admin_comment') }}">{{ $productRate->admin_comment }}</textarea>
                                                    @error('admin_comment')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label" for="admin_approved">@lang('admin.productRates.admin_approved')</label>
                                                <select class="select2 form-control" name="admin_approved" id="select2_admin_approved">
                                                    <option selected value="">
                                                        @lang("admin.productRates.admin_approved")
                                                    </option>
                                                    <option {{ $productRate->admin_approved == 2 ? 'selected' : "" }} value="2">
                                                        @lang("admin.productRates.state_apporved")
                                                    </option>
                                                    <option {{ $productRate->admin_approved == 3 ? 'selected' : "" }} value="3">
                                                        @lang("admin.productRates.state_not_apporved")
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Of Arabic Info tab pane -->
                            </div>
                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="submit"
                                    class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                    @lang('admin.save')
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- end card body -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
@endsection
