@extends('admin.layouts.master')
@section('title')
    @lang('admin.warehouses.manage_warehouses')
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
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.warehouses.manage_warehouses')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("admin.warehouses.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.warehouses.create")
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action=" ">
                        <input type="hidden" name="status" value="{{request()->get('status')}}">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-6">
                                <div class="search-box">
                                    <input name="search" type="text" class="form-control search"
                                           placeholder="@lang("admin.warehouses.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <select name="trans" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option value="all" selected>@lang("admin.customer_finances.wallets.all")</option>
                                        <option value="ar">@lang("admin.warehouses.name_ar")</option>
                                        <option value="en">@lang("admin.warehouses.name_en")</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-true
                                        name="vendor_id" id="is_active">
                                        <option value="" @selected(empty(request()->get('vendor_id'))) >@lang("admin.vendors_list")</option>
                                        @foreach ($vendors as $vendor)
                                        <option value="{{$vendor->id}}" @selected(request()->get('vendor_id') == $vendor->id) >{{$vendor->getTranslation('name','ar')}}  </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <select name="warehouse_type" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option value="" selected>@lang("admin.warehouse_type")</option>
                                        @foreach($shipping_types ?? [] as $shipping_type)
                                        <option value="{{ $shipping_type->id }}" @selected($shipping_type->id == request()->get('warehouse_type'))>
                                            {{ $shipping_type->title }}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                            @lang("admin.warehouses.filter")
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{route('admin.warehouses.index')}}" class="btn btn-info w-100"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                            @lang("admin.warehouses.reset")
                                    </a>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{ route('admin.warehouses.export' , ['search' => request()->get('search') , 'trans' => request()->get('trans'), 'warehouse_type' => request()->get('warehouse_type') , 'vendor_id' => request()->get('vendor_id')  , 'status' => request()->get('status')  ]) }}" class="btn btn-primary"> تصدير Excel</a>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <br>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="warehousesTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.warehouses.id')</th>
                                    <th>@lang('admin.warehouses.vendors')</th>
                                    <th>@lang('admin.warehouses.name')</th>
                                    <th>@lang('admin.warehouse_status')</th>
                                    <th>@lang('admin.warehouses.administrator_phone')</th>
                                    <th>@lang('admin.warehouses.city')</th>
                                    <th>@lang('admin.warehouses.time_work')</th>
                                    <th>@lang('admin.warehouse_type')</th>

                                    <th>@lang('admin.warehouses.administrator_name')</th>
                                    <th>@lang('admin.warehouses.map_url')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($warehouses->count() > 0)
                                        @foreach($warehouses as $warehouse)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("admin.warehouses.show", $warehouse->id) }}" class="fw-medium link-primary">
                                                        #{{$warehouse->id}}
                                                    </a>
                                                </td>
                                                <td class="name_ar">{{ $warehouse->vendor->name }}</td>
                                                <td class="name">{{ $warehouse->name }}</td>
                                                <td>
                                                    <span class="badge badge-info text-uppercase">
                                                        {{ $warehouse->is_active == 1 ? __('admin.warehouse_active') : __('admin.warehouse_inactive') }}
                                                    </span>
                                                </td>
                                                <td class="name_ar">{{ $warehouse->administrator_phone }}</td>
                                                <td class="name">
                                                    @foreach ($warehouse->cities as $city)
                                                        {{$city->getTranslation('name','ar')}}
                                                    @endforeach
                                                </td>
                                                <td class="name">{{$warehouse->time_work_from .' : '. $warehouse->time_work_to}}</td>

                                                <td class="torod_warehouse_name">
                                                    @foreach($warehouse->shippingTypes as $shipping_type)
                                                        <span class="badge badge-info text-uppercase">
                                                            {{ $shipping_type->title }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td class="administrator_name">{{ $warehouse->administrator_name }} / {{ $warehouse->administrator_phone }}</td>
                                                <td>
                                                    <a href="{{$warehouse->googleMapUrl}}" target="_blank">
                                                       <small>Location on map</small>
                                                    </a>
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        @if($warehouse->isPending())
                                                        <span class="badge bg-warning">في إنتظار موافقة</span>
                                                        @elseif($warehouse->isRejected())
                                                            <span class="badge bg-danger" style="text-wrap: wrap; max-width: 300px; ">مرفوض:  {{$warehouse->getLastStatus->note}} </span>
                                                        @elseif($warehouse->isWaitUpdated())
                                                            <span class="badge bg-warning" style="text-wrap: wrap; max-width: 300px; "> في إنتظار موافقة على تعديلات </span>
                                                        @elseif($warehouse->isUpdatedRefused())
                                                        <span class="badge bg-danger" style="text-wrap: wrap; max-width: 300px; ">رفض التعديل:  {{$warehouse->getLastStatus->note}} </span>
                                                        @endif
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.warehouses.show')">
                                                            <a href="{{ route("admin.warehouses.show", $warehouse->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.warehouses.edit')">
                                                            <a href="{{ route("admin.warehouses.edit", $warehouse->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-edit-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deletewarehouse-{{$warehouse->id}}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <!-- Start Delete Modal -->
                                            <div class="modal fade flip" id="deletewarehouse-{{$warehouse->id}}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-5 text-center">
                                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                    colors="primary:#25a0e2,secondary:#00bd9d"
                                                                    style="width:90px;height:90px">
                                                            </lord-icon>
                                                            <div class="mt-4 text-center">
                                                                <h4>@lang('admin.warehouses.delete_modal.title')</h4>
                                                                <p class="text-muted fs-15 mb-4">@lang('admin.warehouses.delete_modal.description')</p>
                                                                <div class="hstack gap-2 justify-content-center remove">
                                                                    <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                            data-bs-dismiss="modal" id="deleteRecord-close">
                                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                                        @lang('admin.close')
                                                                    </button>
                                                                    <form action="{{ route("admin.warehouses.destroy", $warehouse->id) }}" method="post">
                                                                        @csrf
                                                                        @method("DELETE")
                                                                        <button type="submit" class="btn btn-primary" id="delete-record">
                                                                            @lang('admin.warehouses.delete')
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
                                {{ $warehouses->appends(request()->query())->links("pagination::bootstrap-4") }}
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
