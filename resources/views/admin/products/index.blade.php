@extends('admin.layouts.master')
@section('title')
    @lang('admin.products.manage_products')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="products">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-borderless" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.products.manage_products')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("admin.products.create") }}" class="btn btn-primary add-btn"
                                   id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i> @lang("admin.products.create")
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
                                           placeholder="@lang("admin.products.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
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
                                        placeholder="@lang("admin.products.created_at_select")">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="active_status" id="is_active">
                                        <option value="all" selected>@lang("admin.select")</option>
                                        <option @selected(request()->get('active_status') == "active") value="active">@lang("admin.products.active")</option>
                                        <option @selected(request()->get('active_status') == "inactive") value="inactive">@lang("admin.products.inactive")</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="note" id="is_active">
                                        <option value="all" selected>@lang("admin.select")</option>
                                        <option @selected(request()->get('note') == "1") value="1">@lang("admin.products.with_note")</option>
                                        <option @selected(request()->get('note') == "0") value="0">@lang("admin.products.without_note")</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.products.filter")
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
                            <table class="table table-nowrap align-middle" id="productsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.products.id')</th>
                                    <th>@lang('translation.product_image')</th>
                                    <th>@lang('admin.products.name_ar')</th>
                                    <th>@lang('admin.products.category')</th>
                                    <th>@lang('admin.products.vendor')</th>
                                    <th>@lang('admin.products.price')</th>
                                    <th>@lang("translation.stock")</th>
                                    <th>@lang('translation.visible')</th>
                                    <th>@lang('admin.products.is_active')</th>
                                    @if(\Route::currentRouteName() == 'admin.products.deleted')
                                    <th> تاريخ الحذف </th>
                                    @else
                                    <th>@lang('translation.actions')</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if($products->count() > 0)
                                        @foreach($products as $product)
                                            <tr id="product-{{ $product->id }}">
                                                <td class="id">
                                                    <a href="{{ route("admin.products.show", $product->id) }}"
                                                    class="fw-medium link-primary">
                                                        #{{$product->id}}
                                                    </a>
                                                </td>
                                                <td class="product_image">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm bg-light rounded p-1">
                                                            @if($product?->square_image_temp && $product?->square_image_temp != $product?->square_image)
                                                                <img src="{{$product->updateTempForSquareimage() }}" alt="" class="img-fluid d-block">
                                                            @else
                                                                <img src="{{$product?->square_image }}" alt="" class="img-fluid d-block">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="name_ar">{{ $product->getTranslation('name', 'ar') }}</td>
                                                <td class="category">{{ $product?->category?->name }}</td>
                                                <td class="vendor">{{ $product?->vendor?->name }}</td>
                                                <td class="price">{{ number_format($product?->price_in_sar, 2) }} @lang('translation.sar')</td>
                                                <td class="stock text-center">{{ $product->stock ? $product->stock : trans("admin.not_found") }}</td>
                                                <td class="is_active">
                                                    @if($product?->is_visible == 1) <span class="badge badge-soft-success text-uppercase">@lang('admin.products.yes')</span> @else <span class="badge badge-soft-danger text-uppercase"> @lang('admin.products.no') </span>   @endif
                                                    @if($product?->is_active == 0) <span class="badge badge-soft-danger text-uppercase"> مخفي من الإدارة  </span>   @endif
                                                </td>
                                                <td class="status">
                                                    @if($product?->status == 'accepted')
                                                        <span class="badge badge-soft-success text-uppercase"> @lang('admin.products.yes')</span>
                                                    @else
                                                        <span class="badge badge-soft-danger text-uppercase">@lang("admin.products.{$product->status}")</span>
                                                    @endif
                                                </td>
                                                @if(\Route::currentRouteName() == 'admin.products.deleted')
                                                <td> {{$product->deleted_at}} </td>
                                                @else
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        @if($product?->temp?->approval == 'refused')
                                                        <li class="list-inline-item" data-bs-toggle="tooltip">
                                                            <button type="button" class="btn btn-sm btn-warning btnshowmore" data-txt="{{$product->temp->note}}">
                                                                <i class="ri-error-warning-line"></i>
                                                            </button>
                                                        </li>
                                                        @endif
                                                        @if(!empty($product?->note->note))
                                                        <li class="list-inline-item" data-bs-toggle="tooltip">
                                                            <button type="button" class="btn btn-sm btn-warning btnshowmore" data-txt="{{$product?->note->note}}">
                                                                <i class="ri-error-warning-line"></i>
                                                            </button>
                                                        </li>
                                                        @endif

                                                        @if(request()->has('status') && request('status') == 'pending')
                                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.products.accepting')">
                                                            <a href="javascript:void(0);" onclick="productApprove('{{ $product->id }}');">
                                                                <i id="product_approve_icon" class="ri-check-fill"></i>
                                                            </a>
                                                            {{--<a href="javascript:void(0);" onclick="productApprove('{{ $product->id }}');">
                                                                <i id="product_approve_icon" class="ri-check-fill"></i>
                                                            </a>--}}
                                                        </li>
                                                        @endif
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.products.show')">
                                                            <a href="{{ route("admin.products.show", $product->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.products.edit')">
                                                            <a href="{{ route("admin.products.edit", $product->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-edit-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.products.delete')">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="#deleteProduct-{{$product->id}}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                            <!-- Start Delete Modal -->
                                                            <div class="modal fade flip" id="deleteProduct-{{$product->id}}" tabindex="-1" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body p-5 text-center">
                                                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                                    colors="primary:#25a0e2,secondary:#00bd9d"
                                                                                    style="width:90px;height:90px">
                                                                            </lord-icon>
                                                                            <div class="mt-4 text-center">
                                                                                <h4>@lang('admin.products.delete_modal.title')</h4>
                                                                                <p class="text-muted fs-15 mb-4">@lang('admin.products.delete_modal.description')</p>
                                                                                <div class="hstack gap-2 justify-content-center remove">
                                                                                    <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                            data-bs-dismiss="modal" id="deleteRecord-close">
                                                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                                                        @lang('admin.close')
                                                                                    </button>
                                                                                    <form action="{{ route("admin.products.destroy", $product->id) }}" method="post">
                                                                                        @csrf
                                                                                        @method("DELETE")
                                                                                        <button type="submit" class="btn btn-primary" id="delete-record">
                                                                                            @lang('admin.products.delete')
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
                                    <h5 class="mt-2">@lang('admin.products.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $products->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
                    <!-- Start Delete Modal -->
                    <div class="modal fade flip" id="deleteProduct" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#00bd9d"
                                               style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>@lang('admin.products.delete_modal.title')</h4>
                                        <p class="text-muted fs-15 mb-4">@lang('admin.products.delete_modal.description')</p>
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
        function productApprove(productId)
        {
            let productRow = $('#product-'+productId);
            $.post("{{ URL::asset('/admin') }}/products/approve/" + productId, {
                id: productId,
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
                    productRow.remove();
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
