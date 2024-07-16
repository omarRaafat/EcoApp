@extends('admin.layouts.master')
@section('title')
    @lang('admin.services.manage_services')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="services">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.services.manage_services')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("admin.services.create") }}" class="btn btn-primary add-btn"
                                   id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i> @lang("admin.services.create")
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <input type="hidden" name="temp" value="{{request()->get('temp')}}">
                        <input type="hidden" name="status" value="{{request()->get('status')}}">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" name="search" value="{{ request()->get('search') }}"
                                           placeholder="@lang("admin.services.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-true
                                        name="vendor_id" id="is_active">
                                        <option value="" @selected(empty(request()->get('vendor_id'))) >@lang("admin.vendors_list")</option>
                                        @foreach ($vendors as $vendor)
                                        <option value="{{$vendor->id}}" @selected(request()->get('vendor_id') == $vendor->id) >{{$vendor->getTranslation('name','ar')}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <input type="text" class="form-control" data-provider="flatpickr" name="created_date"
                                        data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" value="{{ request()->get('created_date') }}"
                                        placeholder="@lang("admin.services.created_at_select")">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="active_status" id="is_active">
                                        <option value="all" selected>@lang("admin.select")</option>
                                        <option @selected(request()->get('active_status') == "active") value="active">@lang("admin.services.active")</option>
                                        <option @selected(request()->get('active_status') == "inactive") value="inactive">@lang("admin.services.inactive")</option>
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="note" id="is_active">
                                        <option value="all" selected>@lang("admin.select")</option>
                                        <option @selected(request()->get('note') == "1") value="1">@lang("admin.services.with_note")</option>
                                        <option @selected(request()->get('note') == "0") value="0">@lang("admin.services.without_note")</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.services.filter")
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href=" ?action=exportExcel&search={{request()->get('search')}}&created_date={{request()->get('created_date')}}&vendor_id={{request()->get('vendor_id')}}&active_status={{request()->get('active_status')}}&status={{request()->get('status')}}&temp={{request()->get('temp')}}" class="btn btn-primary"> تصدير Excel</a>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <br>
                        <br>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="servicesTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.services.id')</th>
                                    <th>@lang('translation.service_image')</th>
                                    <th>@lang('admin.services.name_ar')</th>
                                    <th>@lang('admin.products.category')</th>
                                    <th>@lang('admin.services.vendor')</th>
                                    <th>@lang('translation.visible')</th>
                                    <th>@lang('admin.services.is_active')</th>
                                    @if(\Route::currentRouteName() == 'admin.services.deleted')
                                    <th> تاريخ الحذف </th>
                                    @else
                                    <th>@lang('translation.actions')</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if($services->count() > 0)
                                        @foreach($services as $service)
                                            <tr id="service-{{ $service->id }}">
                                                <td class="id">
                                                    <a href="{{ route("admin.services.show", $service->id) }}"
                                                    class="fw-medium link-primary">
                                                        #{{$service->id}}
                                                    </a>
                                                </td>
                                                <td class="service_image">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm bg-light rounded p-1">
                                                            @if($service?->square_image_temp && $service?->square_image_temp != $service?->square_image)
                                                                <img src="{{$service->updateTempForSquareimage() }}" alt="" class="img-fluid d-block">
                                                            @else
                                                                <img src="{{$service?->square_image }}" alt="" class="img-fluid d-block">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="name_ar">{{ $service->getTranslation('name', 'ar') }}</td>
                                                <td class="category">{{ $service?->category?->name }}</td>
                                                <td class="vendor">{{ $service?->vendor?->name }}</td>
                                                <td class="is_active">
                                                    @if($service?->is_visible == 1) <span class="badge badge-soft-success text-uppercase">@lang('admin.services.yes')</span> @else <span class="badge badge-soft-danger text-uppercase"> @lang('admin.services.no') </span>   @endif
                                                    @if($service?->is_active == 0) <span class="badge badge-soft-danger text-uppercase"> مخفي من الإدارة  </span>   @endif
                                                </td>
                                                <td class="status">
                                                    @if($service?->status == 'accepted')
                                                        <span class="badge badge-soft-success text-uppercase"> @lang('admin.services.yes')</span>
                                                    @else
                                                        <span class="badge badge-soft-danger text-uppercase">@lang("admin.services.{$service->status}")</span>
                                                    @endif
                                                </td>
                                                @if(\Route::currentRouteName() == 'admin.services.deleted')
                                                <td> {{$service->deleted_at}} </td>
                                                @else
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        @if($service?->temp?->approval == 'refused')
                                                        <li class="list-inline-item" data-bs-toggle="tooltip">
                                                            <button type="button" class="btn btn-sm btn-warning btnshowmore" data-txt="{{$service->temp->note}}">
                                                                <i class="ri-error-warning-line"></i>
                                                            </button>
                                                        </li>
                                                        @endif
                                                        @if(!empty($service?->note->note))
                                                        <li class="list-inline-item" data-bs-toggle="tooltip">
                                                            <button type="button" class="btn btn-sm btn-warning btnshowmore" data-txt="{{$service?->note->note}}">
                                                                <i class="ri-error-warning-line"></i>
                                                            </button>
                                                        </li>
                                                        @endif

                                                        @if(request()->has('status') && request('status') == 'pending')
                                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.services.accepting')">
                                                            <a href="javascript:void(0);" onclick="serviceApprove('{{ $service->id }}');">
                                                                <i id="service_approve_icon" class="ri-check-fill"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.services.show')">
                                                            <a href="{{ route("admin.services.show", $service->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.services.edit')">
                                                            <a href="{{ route("admin.services.edit", $service->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-edit-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.services.delete')">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="#deleteService-{{$service->id}}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                            <!-- Start Delete Modal -->
                                                            <div class="modal fade flip" id="deleteService-{{$service->id}}" tabindex="-1" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body p-5 text-center">
                                                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                                    colors="primary:#25a0e2,secondary:#00bd9d"
                                                                                    style="width:90px;height:90px">
                                                                            </lord-icon>
                                                                            <div class="mt-4 text-center">
                                                                                <h4>@lang('admin.services.delete_modal.title')</h4>
                                                                                <p class="text-muted fs-15 mb-4">@lang('admin.services.delete_modal.description')</p>
                                                                                <div class="hstack gap-2 justify-content-center remove">
                                                                                    <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                            data-bs-dismiss="modal" id="deleteRecord-close">
                                                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                                                        @lang('admin.close')
                                                                                    </button>
                                                                                    <form action="{{ route("admin.services.destroy", $service->id) }}" method="post">
                                                                                        @csrf
                                                                                        @method("DELETE")
                                                                                        <button type="submit" class="btn btn-primary" id="delete-record">
                                                                                            @lang('admin.services.delete')
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Delete Modal -->
                                                        </li>
                                                    </ul>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.services.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $services->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
                    <!-- Start Delete Modal -->
                    <div class="modal fade flip" id="deleteService" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#00bd9d"
                                               style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>@lang('admin.services.delete_modal.title')</h4>
                                        <p class="text-muted fs-15 mb-4">@lang('admin.services.delete_modal.description')</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                    data-bs-dismiss="modal" id="deleteRecord-close"><i
                                                    class="ri-close-line me-1 align-middle"></i>
                                                Close
                                            </button>
                                            <button class="btn btn-primary" id="delete-record">Yes,
                                                Delete It
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Delete Modal -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تفاصيل رفض  التعديل </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent" >
                <!-- Content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
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
@section('script-bottom')
    <script>
        function serviceApprove(serviceId)
        {
            let serviceRow = $('#service-'+serviceId);
            $.post("{{ URL::asset('/admin') }}/services/approve/" + serviceId, {
                id: serviceId,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>' + data.message + '</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    serviceRow.remove();
                }
            }, "json");
        }
    </script>
    <script>
        $(".btnshowmore").on("click", function() {
            $('#modalContent').html($(this).data('txt'));
            $('#myModal').modal('show');

         });
    </script>
@endsection
