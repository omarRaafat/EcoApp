@extends('admin.layouts.master')
@section('title')
    @lang('admin.line_shipping_price')
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
            <div class="card" id="warehouses">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.line_shipping_price')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">

                                @if (auth()->user()?->isAdminPermittedTo("admin.line_shipping_price.create"))

                                <a href="{{ route("admin.line_shipping_price.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.line_shipping.add")
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                </div>
                <br>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="warehousesTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.id')</th>
                                    <th>@lang('admin.city_from')</th>
                                    <th>@lang('admin.city_to')</th>
                                    <th>@lang('admin.dyna')</th>
                                    <th>@lang('admin.lorry')</th>
                                    <th>@lang('admin.truck')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @if ($lineShippingPrices->count() > 0)
                                    @foreach($lineShippingPrices as $lineShippingPrice)
                                        <tr>
                                            <td class="id">
                                                <a href="{{ route("admin.warehouses.show", $lineShippingPrice->id) }}"class="fw-medium link-primary">
                                                    #{{$lineShippingPrice->id}}
                                                </a>
                                            </td>
                                            <td class="name_ar">{{ $lineShippingPrice->city('name') ?? '---' }}</td>
                                            <td class="name">{{ $lineShippingPrice->city_to('name') ?? '---' }}</td>

                                            <td class="name">{{ $lineShippingPrice->dyna }}</td>
                                            <td class="name">{{ $lineShippingPrice->lorry }}</td>
                                            <td class="name">{{ $lineShippingPrice->truck }}</td>

                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    @if (auth()->user()?->isAdminPermittedTo("admin.line_shipping_price.edit"))

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.warehouses.edit')">
                                                        <a href="{{ route("admin.line_shipping_price.edit", $lineShippingPrice->id) }}"
                                                           class="text-primary d-inline-block">
                                                            <i class="ri-edit-2-line"></i>
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if (auth()->user()?->isAdminPermittedTo("admin.line_shipping_price.destroy"))

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                           data-bs-toggle="modal" href="#deletewarehouse-{{$lineShippingPrice->id}}">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                        <!-- Start Delete Modal -->
                                        <div class="modal fade flip" id="deletewarehouse-{{$lineShippingPrice->id}}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body p-5 text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                   colors="primary:#25a0e2,secondary:#00bd9d"
                                                                   style="width:90px;height:90px">
                                                        </lord-icon>
                                                        <div class="mt-4 text-center">
                                                            <h4>@lang('admin.line_shipping.delete_modal.title')</h4>
                                                            <p class="text-muted fs-15 mb-4">@lang('admin.warehouses.delete_modal.description')</p>
                                                            <div class="hstack gap-2 justify-content-center remove">
                                                                <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                        data-bs-dismiss="modal" id="deleteRecord-close">
                                                                    <i class="ri-close-line me-1 align-middle"></i>
                                                                    @lang('admin.close')
                                                                </button>
                                                                <form action="{{ route("admin.line_shipping_price.destroy", $lineShippingPrice->id) }}" method="post">
                                                                    @csrf
                                                                    @method("DELETE")
                                                                    <button type="submit" class="btn btn-primary" id="delete-record">
                                                                        @lang('admin.delete')
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Delete Modal -->
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan = "4">
                                            <center>
                                                @lang('admin.warehouses.not_found')
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
                                <h5 class="mt-2">@lang('admin.warehouses.no_result_found')</h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            {{ $lineShippingPrices->appends(request()->query())->links("pagination::bootstrap-4") }}
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
