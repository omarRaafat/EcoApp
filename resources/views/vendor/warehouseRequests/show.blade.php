@extends('vendor.layouts.master')
@section('title')
    @lang('admin.wareHouseRequests.manage_wareHouseRequests')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wareHouseRequests">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.wareHouseRequests.manage_wareHouseRequests')</h5>
                        <div class="flex-shrink-0">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route("vendor.warhouse_request.show",$id) }}">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="search" type="text" class="form-control search"
                                           placeholder="@lang("admin.wareHouseRequests.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div>
                                    <select name="trans" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option value="all" selected>@lang("admin.wareHouseRequests.all")</option>
                                        <option value="product_ar">@lang("admin.wareHouseRequests.name_ar")</option>
                                        <option value="product_en">@lang("admin.wareHouseRequests.name_en")</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                            @lang("admin.wareHouseRequests.filter")
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <br>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="wareHouseRequestsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.wareHouseRequests.id')</th>
                                    <th>@lang('admin.wareHouseRequests.vendor')</th>
                                    <th>@lang('admin.wareHouseRequests.name_ar')</th>
                                    <th>@lang('admin.wareHouseRequests.name_en')</th>
                                    <th>@lang('admin.wareHouseRequests.created_at')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($vendorRequests->count() > 0)
                                        @foreach($vendorRequests as $vendorRequest)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("vendor.warhouse_request.show-products", $vendorRequest->id) }}"class="fw-medium link-primary">
                                                        #{{$vendorRequest->id}} 
                                                    </a>
                                                </td>
                                                <td class="vendor">{{ $vendorRequest->request->vendor->name }}</td>
                                                <td class="product_ar">{{ $vendorRequest->product->getTranslation('name', 'ar') }}</td>
                                                <td class="product_en">{{ $vendorRequest->product->getTranslation('name', 'en') }}</td>
                                                <td class="product_en">{{ $vendorRequest->created_at }}</td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.wareHouseRequests.show')">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalId{{$vendorRequest->id}}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                            <div class="modal fade bs-example-modal-center bs-example-modal-xl" id="modalId{{$vendorRequest->id}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body text-center p-5 row">
                                                                        <div class="col-xl-12">
                                                                            <div class="sticky-side-div">
                                                                                <div class="card">
                                                                                    <div class="card-header border-bottom-dashed">
                                                                                        <h5 class="card-title mb-0">@lang('translation.warehouse_request_details')</h5>
                                                                                    </div>
                                                                                    <div class="card-body pt-2">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-borderless mb-0">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td>@lang('admin.wareHouseRequests.id') :</td>
                                                                                                        <td class="text-end" id="cart-subtotal">{{ $vendorRequest->id }}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>@lang("admin.wareHouseRequests.vendor") <span class="text-muted"></span> : </td>
                                                                                                        <td class="text-end" id="cart-discount">{{ $vendorRequest->request->vendor->name }}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>@lang("translation.product_name") :</td>
                                                                                                        <td class="text-end" id="cart-shipping">{{ $vendorRequest->product->getTranslation('name', 'ar') }}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>@lang("admin.wareHouseRequests.qnt") : </td>
                                                                                                        <td class="text-end" id="cart-tax">{{ $vendorRequest->qnt }}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>@lang("admin.wareHouseRequests.mnfg_date") : </td>
                                                                                                        <td class="text-end" id="cart-tax">{{ $vendorRequest->mnfg_date->toDayDateTimeString() }}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>@lang("admin.wareHouseRequests.expire_date") : </td>
                                                                                                        <td class="text-end" id="cart-tax">{{ $vendorRequest->expire_date->toDayDateTimeString() }}</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <!-- end table-responsive -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- end stickey -->
                                                                        </div>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->
                                                        </li>
                                                        
                                                    </ul>
                                                </td>
                                            </tr>
                                            <!-- Start Delete Modal -->
                                            
                                            <!-- End Delete Modal -->
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan = "4">
                                                <center>
                                                    @lang('admin.wareHouseRequests.not_found')
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                    <!-- End Delete Modal -->
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.wareHouseRequests.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $vendorRequests->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
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
