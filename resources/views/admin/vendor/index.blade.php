@extends('admin.layouts.master')
@section('title')
    @lang('admin.vendors_list')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.vendors_list')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="{{ URL::asset('/admin') }}/vendors/">
                        <!-- Col Form Label Default -->
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('name') }}" name="name" type="text"
                                        class="form-control search" placeholder="@lang('admin.vendor_name')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select name="approval" class="form-control" data-choices data-choices-search-false
                                    name="choices-single-default" id="idApproval">
                                    <option @if (request('approval') == '') SELECTED @endif value="">
                                        @lang('admin.vendor_status')</option>
                                    <option @if (request('approval') == 'pending') SELECTED @endif value="pending">
                                        @lang('admin.vendor_pending')</option>
                                    <option @if (request('approval') == 'approved') SELECTED @endif value="approved">
                                        @lang('admin.vendor_approved')</option>
                                    <option @if (request('approval') == 'not_approved') SELECTED @endif value="not_approved">
                                        @lang('admin.vendor_not_approved')</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select name="rating" class="form-control" data-choices data-choices-search-false
                                    name="choices-single-default" id="idRating">
                                    <option @if (request('rating') == '') SELECTED @endif value="">
                                        @lang('admin.vendor_rate')</option>
                                    <option @if (request('rating') == '1') SELECTED @endif value="1"><i
                                            class="fas fa-star {{ request('rating') >= 1 ? 'clr_yellow' : '' }}">1</i>
                                    </option>
                                    <option @if (request('rating') == '2') SELECTED @endif value="2"><i
                                            class="fas fa-star {{ request('rating') >= 2 ? 'clr_yellow' : '' }}">2</i>
                                    </option>
                                    <option @if (request('rating') == '3') SELECTED @endif value="3"><i
                                            class="fas fa-star {{ request('rating') >= 3 ? 'clr_yellow' : '' }}">3</i>
                                    </option>
                                    <option @if (request('rating') == '4') SELECTED @endif value="4"><i
                                            class="fas fa-star {{ request('rating') >= 4 ? 'clr_yellow' : '' }}">4</i>
                                    </option>
                                    <option @if (request('rating') == '5') SELECTED @endif value="5"><i
                                            class="fas fa-star {{ request('rating') >= 5 ? 'clr_yellow' : '' }}">5</i>
                                    </option>
                                </select>
                            </div>
                            <div class="col-xxl-4 col-sm-4">
                                <select name="commission_sort" class="form-control" data-choices data-choices-search-false
                                    name="choices-single-default" id="idCommission">
                                    <option @if (request('commission_sort') == '') SELECTED @endif value="">
                                        @lang('admin.vendor_admin_percentage_order')</option>
                                    <option @if (request('commission_sort') == 'desc') SELECTED @endif value="desc">
                                        @lang('admin.desc_order')</option>
                                    <option @if (request('commission_sort') == 'asc') SELECTED @endif value="asc">
                                        @lang('admin.asc_order')</option>
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
                                <th scope="col">@lang('admin.vendor_products')</th>
                                <th scope="col">@lang('admin.vendor_rate')</th>
                                <th scope="col">@lang('admin.vendor_sales')</th>
                                {{-- <th scope="col">@lang('admin.vendor_external_warehouse')</th> --}}
                                <th scope="col">@lang('admin.vendor_registration_date')</th>
                                @if (auth()->user()
                                        ?->isAdminPermittedTo('admin.vendors.warnings.index'))
                                    <th scope="col">@lang('admin.vendor_warnings')</th>
                                @endif
                                {{-- @if (auth()->user()
                                        ?->isAdminPermittedTo('admin.vendors.accept-set-ratio')) --}}
                                    <th scope="col">@lang('admin.vendor_admin_percentage')</th>
                                {{-- @endif --}}


                                @if (auth()->user()
                                        ?->isAdminPermittedTo('admin.vendors.change-status'))
                                <th scope="col">@lang('admin.vendor_status')</th>
                                @endif
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr>
                                    <td>{{ $vendor->id }}</td>
                                    <td>
                                        <img class="img-thumbnail" src="{{ ossStorageUrl($vendor->logo) }}"
                                            style="height:40px;"> {{ $vendor->name }}
                                    </td>
                                    <td align="center">
                                        <span class="badge badge-info"> {{ $vendor->products->count() }}</span>
                                    </td>
                                    <td style="width: 114px; !important">
                                        <div class="stars">
                                            <i class="mdi mdi-star text-warning me-1"></i>
                                            ({{ $vendor->ratings_count }})
                                        </div>
                                    </td>
                                    <td align="center">
                                        <span class="badge badge-info"> {{ $vendor->orders->count() }}</span>
                                    </td>
                                    {{-- <td>{{isset($warehouse->name) ? $warehouse->name :  ''}}</td> --}}
                                    <td>{{ date('d-m-Y h:i', strtotime($vendor->created_at)) }}</td>
                                    @if (auth()->user()
                                            ?->isAdminPermittedTo('admin.vendors.warnings.index'))
                                        <td>
                                            <a href="{{ route('admin.vendors.warnings.index', ['vendor' => $vendor]) }}"
                                                class="full-width">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30"
                                                    height="30">
                                                    <path fill="none" d="M0 0h24v24H0z" />
                                                    <path
                                                        d="M12.866 3l9.526 16.5a1 1 0 0 1-.866 1.5H2.474a1 1 0 0 1-.866-1.5L11.134 3a1 1 0 0 1 1.732 0zm-8.66 16h15.588L12 5.5 4.206 19zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"
                                                        fill="rgba(190,154,17,1)" />
                                                </svg>
                                                ({{ $vendor->VendorWarnings->count() }})
                                            </a>
                                        </td>
                                    @endif
                                    {{-- @if (auth()->user()
                                            ?->isAdminPermittedTo('admin.vendors.accept-set-ratio')) --}}
                                        <td class="commission">% {{ (int) $vendor->commission }}</td>
                                    {{-- @endif --}}
                                    @if (auth()->user()
                                    ?->isAdminPermittedTo('admin.vendors.change-status'))
                                    <td>
                                        <div class="form-check form-switch">
                                            <input onclick="vendorChangeStatus('{{ $vendor->id }}',this)"
                                                class="form-check-input" type="checkbox" role="switch"
                                                id="SwitchCheck4"
                                                @if ($vendor->is_active == 1) value="1" checked=""
                                               @else value="0" @endif />
                                        </div>
                                    </td>
                                    @endif
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">

                                            @if ($vendor->approval != 'approved')
                                            @if (auth()->user()
                                        ?->isAdminPermittedTo('admin.vendors.accept-set-ratio'))
                                                <a href="javascript:void(0);"
                                                    onclick="set_accept_to_vendor('{{ $vendor->id }}',this);">
                                                    <i id="vendor_approve_icon" class="ri-check-fill"></i>
                                                </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0);"
                                                    onclick="vendorApprove('{{ $vendor->id }}',this);">
                                                    <i id="vendor_approve_icon"
                                                        class="link-danger ri-indeterminate-circle-fill"></i>
                                                </a>
                                            @endif

                                            @if (auth()->user()
                                                    ?->isAdminPermittedTo('admin.vendors.show'))
                                                <a href="{{ route('admin.vendors.show', ['vendor' => $vendor]) }}"
                                                    class="fs-15">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            @endif
                                            @if (auth()->user()
                                                    ?->isAdminPermittedTo('admin.vendors-agreements.index'))
                                                <a href="{{ route('admin.vendors-agreements.index', ['vendor' => $vendor->id]) }}"
                                                    class="fs-15" title="@lang('admin.show-vendor-agreements')">
                                                   <i class="ri-file-paper-2-fill"></i>
                                                </a>
                                            @endif
                                            @if (auth()->user()
                                                    ?->isAdminPermittedToList(['admin.vendors.edit', 'admin.vendors.update']))
                                                <a href="{{ route('admin.vendors.edit', ['vendor' => $vendor]) }}"
                                                    class="fs-15">
                                                    <i class="ri-edit-2-line"></i>
                                                </a>
                                            @endif
                                            {{-- TODO: Remove delete from controller and route --}}
                                            {{-- <a href="{{ route('admin.vendorsDelete', ['vendor' => $vendor]) }}" class="fs-15 link-danger">
                                            <i class="ri-delete-bin-line"></i>
                                        </a> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $vendors->links() }}
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
        function vendorApprove(vendorId, item) {
            let iconSpan = $(item).find('#vendor_approve_icon');
            $.post("{{ URL::asset('/admin') }}/vendors/approve/" + vendorId, {
                id: vendorId,
                "_token": "{{ csrf_token() }}"
            }, function(data) {
                if (data.status == 'success') {
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
                    if (data.data != 'approved') {
                        iconSpan.removeClass('link-danger ri-indeterminate-circle-fill').addClass('ri-check-fill');
                        $(item).attr('onclick', "set_accept_to_vendor('" + vendorId + "',this);")
                    } else {
                        iconSpan.removeClass('ri-check-fill').addClass('link-danger ri-indeterminate-circle-fill');
                        $(item).attr('onclick', "vendorApprove('" + vendorId + "',this);")
                    }
                }
            }, "json");
        }

        function set_accept_to_vendor(id, item) {
            Swal.fire({
                title: '@lang('admin.vendor_admin_percentage_hint')',
                icon: 'question',
                input: 'range',
                inputLabel: '@lang('admin.vendor_admin_percentage')',
                showCancelButton: false,
                confirmButtonText: '@lang('admin.save')',
                /*cancelButtonText: '@lang('admin.no')',*/
                reverseButtons: true,
                inputAttributes: {
                    min: 0,
                    max: 100,
                    step: 1
                },
                inputValue: 10,
            }).then((result) => {
                if (parseInt(result.value) != null && parseInt(result.value) >= 0) {
                    var data = {
                        'id': id,
                        'ratio': parseInt(result.value),
                        "_token": "{{ csrf_token() }}",
                    };

                    $.ajax({
                        url: "{{ URL::asset('/admin') }}/vendors/accept-set-ratio",
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        success: function(data) {
                            $(item).parents('tr').find(".commission").text("% " + parseInt(result
                                .value));
                            vendorApprove(id, item);
                        }
                    });
                }
            });
        }

        function vendorChangeStatus(vendorId, item) {
            $.post("{{ URL::asset('/admin') }}/vendors/activation/" + vendorId, {
                id: vendorId,
                "_token": "{{ csrf_token() }}"
            }, function(data) {
                if (data.status == 'success' && data.data != 1) {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>' + data.message + '</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary w-xs mb-1',
                        cancelButtonText: '@lang('admin.back')',
                        buttonsStyling: false,
                        showCloseButton: true
                    });
                }
            }, "json");
        }
    </script>
@endsection
